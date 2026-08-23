<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\cfc_booking\Form\GuestsForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Step 4 of the journey: summary of the reservation just created, before
 * payment (if any) or the final "My Account" confirmation. Also embeds
 * GuestsForm so guests can be added/removed at this stage.
 */
class ReviewController extends ControllerBase {

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
   * Builds the review page render array.
   */
  public function build(NodeInterface $node): array|RedirectResponse {
    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    $space = $node->get('field_space')->entity;
    $owner = $node->getOwner();
    $is_paid = $node->get('field_payment_status')->value === 'pending';

    $amount = $node->get('field_amount')->value;
    $price_label = $amount
      ? number_format((float) $amount, 2) . ' ' . $node->get('field_currency')->value
      : (string) $this->t('Free');
    $max_guests = $space ? (int) $space->get('field_max_guests')->value : 0;

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:booking-review-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'space_label' => $space ? $space->label() : (string) $this->t('Unknown space'),
        'date' => (string) $node->get('field_booking_date')->value,
        'time' => (string) $node->get('field_time_slot')->value,
        'duration' => (string) $node->get('field_duration')->value,
        'user_name' => $owner->getDisplayName(),
        'account_type_label' => $owner->hasRole('journalist') ? (string) $this->t('Journalist') : (string) $this->t('CFC Member'),
        'reference' => (string) $node->get('field_reference')->value,
        'price_label' => $price_label,
        'max_guests' => $max_guests,
        'edit_url' => Url::fromRoute('cfc_booking.cancel', ['node' => $node->id()], ['query' => ['destination' => '/booking']])->toString(),
        'confirm_url' => Url::fromRoute('cfc_booking.pay', ['node' => $node->id()])->toString(),
        'confirm_label' => $is_paid ? (string) $this->t('Proceed to payment') : (string) $this->t('Continue'),
      ],
      '#slots' => [
        'guests_form' => $this->cfcFormBuilder->getForm(GuestsForm::class, $node),
      ],
      '#cache' => [
        'contexts' => ['user'],
        'tags' => ['node:' . $node->id()],
      ],
    ];
  }

}
