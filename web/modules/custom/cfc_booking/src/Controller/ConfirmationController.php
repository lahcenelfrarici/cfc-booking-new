<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Final step of the journey: the confirmed reservation's digital access
 * card — reference, attendee details and a QR placeholder, matching the
 * BookingJourney prototype's ConfirmationStep + PrintableCard.
 */
class ConfirmationController extends ControllerBase {

  public function __construct(
    protected ThemeExtensionList $themeExtensionList,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('extension.list.theme'));
  }

  /**
   * Builds the confirmation page render array.
   */
  public function build(NodeInterface $node): array|RedirectResponse {
    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    $space = $node->get('field_space')->entity;
    $owner = $node->getOwner();
    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:confirmation-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
        'reference' => (string) $node->get('field_reference')->value,
        'user_name' => $owner->getDisplayName(),
        'account_type_label' => $owner->hasRole('journalist') ? (string) $this->t('Journalist') : (string) $this->t('CFC Member'),
        'organization' => (string) ($owner->get('field_organization')->value ?: ''),
        'space_label' => $space ? $space->label() : (string) $this->t('Unknown space'),
        'date' => (string) $node->get('field_booking_date')->value,
        'time' => (string) $node->get('field_time_slot')->value,
        'duration' => (string) $node->get('field_duration')->value,
      ],
      '#cache' => [
        'contexts' => ['user'],
        'tags' => ['node:' . $node->id()],
      ],
    ];
  }

}
