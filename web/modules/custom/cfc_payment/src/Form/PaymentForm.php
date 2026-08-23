<?php

namespace Drupal\cfc_payment\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Stripe\StripeClient;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The right-hand action panel of "Complete your booking" (step 5).
 *
 * Two branches, chosen by the booking's field_payment_status:
 *  - 'pending' (Studio): a real Stripe Card Element that creates/attaches a
 *    PaymentIntent and confirms it client-side via Stripe.js — the card
 *    number never reaches this server. On submit we only receive the
 *    PaymentIntent ID back. Whether the charge actually succeeded is
 *    confirmed two ways: here, as a fast-path UX check, so the user gets an
 *    immediate result; authoritatively, by StripeWebhookSubscriber, which is
 *    the only thing allowed to treat a booking as definitively paid.
 *  - 'not_applicable' (Desk/Meeting Room): no charge is possible, so this is
 *    just a single confirm button — no data changes, purely a UX step
 *    matching the booking journey's step 5 before the confirmation page.
 */
class PaymentForm extends FormBase {

  public function __construct(
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
    protected AccountProxyInterface $currentUser,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_payment_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?NodeInterface $node = NULL): array {
    if (!$this->isAccessible($node)) {
      $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
      return $form;
    }

    $form_state->set('cfc_booking_nid', (int) $node->id());
    $is_payable = $node->get('field_payment_status')->value === 'pending';
    $form_state->set('cfc_is_payable', $is_payable);

    if (!$is_payable) {
      $form['confirm'] = [
        '#type' => 'container',
        '#attributes' => ['class' => ['bg-[#9F5434]/5', 'border', 'border-[#9F5434]/20', 'rounded-3xl', 'p-10', 'text-center']],
      ];
      $form['confirm']['icon'] = [
        '#type' => 'container',
        '#attributes' => ['class' => ['w-14', 'h-14', 'rounded-full', 'bg-[#9F5434]/10', 'flex', 'items-center', 'justify-center', 'mx-auto', 'mb-5']],
        'svg' => [
          '#type' => 'component',
          '#component' => 'cfc_media_hub:icon',
          '#props' => ['name' => 'check-circle-2', 'size' => 'w-7 h-7 text-[#9F5434]'],
        ],
      ];
      $form['confirm']['heading'] = [
        '#markup' => '<h2 class="tracking-tight mb-3" style="font-size: 28px; font-weight: 600;">' . $this->t('No payment required.') . '</h2>',
      ];
      $form['confirm']['description'] = [
        '#markup' => '<p class="text-[15px] text-neutral-600 leading-relaxed mb-8 max-w-[360px] mx-auto">'
          . $this->t('Desks and Meeting Rooms are available free of charge for international accredited journalists. Simply confirm to finalise your reservation.')
          . '</p>',
      ];
      $form['confirm']['submit'] = [
        '#type' => 'submit',
        '#value' => $this->t('Confirm reservation'),
        '#attributes' => ['class' => ['bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'text-white', 'px-8', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors']],
      ];
      return $form;
    }

    $amount = (float) $node->get('field_amount')->value;
    $currency = strtoupper($node->get('field_currency')->value ?: 'EUR');

    $form['card'] = [
      '#type' => 'stripe',
      '#title' => $this->t('Card details'),
      '#stripe_amount' => (int) round($amount * 100),
      '#stripe_currency' => strtolower($currency),
      '#stripe_paymentintent' => [
        'metadata' => [
          'booking_id' => (string) $node->id(),
          'reference' => (string) $node->get('field_reference')->value,
        ],
      ],
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Pay @amount @currency', [
        '@amount' => number_format($amount, 2),
        '@currency' => $currency,
      ]),
      '#attributes' => ['class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    if (!$form_state->get('cfc_is_payable')) {
      return;
    }
    $card = $form_state->getValue('card');
    if (empty($card['payment_intent'])) {
      $form_state->setErrorByName('card', $this->t('Please enter your card details.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $nid = $form_state->get('cfc_booking_nid');
    $node = $nid ? $this->cfcEntityTypeManager->getStorage('node')->load($nid) : NULL;

    if (!$this->isAccessible($node)) {
      $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
      return;
    }

    if ($form_state->get('cfc_is_payable')) {
      $card = $form_state->getValue('card');
      $payment_intent_id = $card['payment_intent'];
      $node->set('field_stripe_payment_intent', $payment_intent_id);

      if ($this->paymentSucceeded($payment_intent_id)) {
        $node->set('field_payment_status', 'paid');
        $this->messenger()->addStatus($this->t('Payment received. Your booking is confirmed.'));
      }
      else {
        $this->messenger()->addStatus($this->t('Payment submitted. We will confirm your booking shortly.'));
      }
      $node->save();
    }

    $form_state->setRedirectUrl(Url::fromRoute('cfc_booking.confirmation', ['node' => $node->id()]));
  }

  /**
   * A booking's payment step is reachable by its owner, for a real "booking"
   * node, as long as it isn't already fully paid (PaymentController redirects
   * that case to the confirmation page before this form is even built).
   */
  protected function isAccessible(?NodeInterface $node): bool {
    return $node
      && $node->bundle() === 'booking'
      && (int) $node->getOwnerId() === (int) $this->currentUser->id()
      && $node->get('field_payment_status')->value !== 'paid';
  }

  /**
   * Retrieves the PaymentIntent from Stripe to check its live status.
   *
   * Fast-path UX only — see class docblock. Fails closed (FALSE) on any
   * error so the definitive "paid" status only ever comes from the webhook.
   */
  protected function paymentSucceeded(string $payment_intent_id): bool {
    $config = \Drupal::config('stripe.settings');
    $secret = $config->get('apikey.' . $config->get('environment') . '.secret');
    if (!$secret) {
      return FALSE;
    }
    try {
      $client = new StripeClient($secret);
      $intent = $client->paymentIntents->retrieve($payment_intent_id);
      return $intent->status === 'succeeded';
    }
    catch (\Throwable $e) {
      return FALSE;
    }
  }

}
