<?php

namespace Drupal\cfc_payment\Controller;

use Drupal\cfc_payment\Form\PaymentForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Step 5 of the journey: "Complete your booking" — a reservation summary
 * card next to either a real Stripe payment form (Studio) or a simple "no
 * payment required" confirm action (Desk/Meeting Room), built by PaymentForm
 * (cfc_payment module) and wrapped in the site's visual shell.
 */
class PaymentController extends ControllerBase {

  public function __construct(
    protected FormBuilderInterface $cfcFormBuilder,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('form_builder'));
  }

  /**
   * Builds the "Complete your booking" page render array.
   */
  public function build(NodeInterface $node): array|RedirectResponse {
    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    // Already paid (or never needed to be) — nothing left to do here.
    if ($node->get('field_payment_status')->value === 'paid') {
      return new RedirectResponse(Url::fromRoute('cfc_booking.confirmation', ['node' => $node->id()])->toString());
    }

    $space = $node->get('field_space')->entity;
    $amount = $node->get('field_amount')->value;
    $total_label = $amount
      ? number_format((float) $amount, 2) . ' ' . $node->get('field_currency')->value
      : (string) $this->t('Free');

    $guest_names = array_map(
      static fn($item) => (string) $item->value,
      iterator_to_array($node->get('field_guest_names'))
    );

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:payment-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'space_label' => $space ? $space->label() : (string) $this->t('Unknown space'),
        'date' => (string) $node->get('field_booking_date')->value,
        'time' => (string) $node->get('field_time_slot')->value,
        'duration' => (string) $node->get('field_duration')->value,
        'user_name' => $node->getOwner()->getDisplayName(),
        'guest_names' => $guest_names,
        'total_label' => $total_label,
        'reference' => (string) $node->get('field_reference')->value,
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(PaymentForm::class, $node),
      ],
    ];
  }

}
