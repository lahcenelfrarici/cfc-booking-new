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
 * Real Stripe card payment for a paid booking (currently: Studio).
 *
 * The Stripe Card Element (module `stripe`) creates/attaches a PaymentIntent
 * and confirms it client-side via Stripe.js — the card number never reaches
 * this server. On submit we only receive the PaymentIntent ID back. Whether
 * the charge actually succeeded is confirmed two ways:
 *  - here, as a fast-path UX check, so the user gets an immediate result;
 *  - authoritatively, by StripeWebhookSubscriber, which is the only thing
 *    allowed to treat a booking as definitively paid (e.g. for anything
 *    that matters operationally — the fast path is UX only).
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
    if (!$this->isPayable($node)) {
      $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
      return $form;
    }

    $form_state->set('cfc_booking_nid', (int) $node->id());

    $space = $node->get('field_space')->entity;
    $amount = (float) $node->get('field_amount')->value;
    $currency = strtoupper($node->get('field_currency')->value ?: 'EUR');

    $form['summary'] = [
      '#markup' => '<div class="cfc-payment-summary space-y-1 mb-6 text-[14px] text-neutral-700">'
        . '<p class="font-semibold text-neutral-900">' . ($space ? $space->label() : (string) $this->t('Booking')) . '</p>'
        . '<p>' . $node->get('field_booking_date')->value . ' — ' . $node->get('field_time_slot')->value . ' (' . $node->get('field_duration')->value . ')</p>'
        . '<p>' . number_format($amount, 2) . ' ' . $currency . '</p>'
        . '</div>',
    ];

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

    if (!$this->isPayable($node)) {
      $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
      return;
    }

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

    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
  }

  /**
   * A booking can be paid if it belongs to the current user, is a real
   * "booking" node, and still has an outstanding balance.
   */
  protected function isPayable(?NodeInterface $node): bool {
    return $node
      && $node->bundle() === 'booking'
      && (int) $node->getOwnerId() === (int) $this->currentUser->id()
      && $node->get('field_payment_status')->value === 'pending';
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
