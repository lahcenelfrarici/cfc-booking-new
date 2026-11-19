<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\cfc_booking\Form\BookingForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Builds the "Modify reservation" page — the same BookingForm the public
 * booking flow uses, in its edit mode (see BookingForm::buildForm()'s
 * $edit_booking parameter).
 */
class ModifyBookingController extends ControllerBase {

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
   * Builds the render array, or redirects back to My Account with an error
   * if the booking isn't the current user's own, or isn't still upcoming
   * (a cancelled/completed reservation can't be modified).
   */
  public function build(NodeInterface $node): array|RedirectResponse {
    $account_url = Url::fromRoute('cfc_pages.account')->toString();

    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      $this->messenger()->addError($this->t('Reservation not found.'));
      return new RedirectResponse($account_url);
    }
    if ($node->get('field_status')->value !== 'upcoming') {
      $this->messenger()->addError($this->t('Only upcoming reservations can be modified.'));
      return new RedirectResponse($account_url);
    }

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:booking-form-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(BookingForm::class, NULL, $node),
      ],
    ];
  }

}
