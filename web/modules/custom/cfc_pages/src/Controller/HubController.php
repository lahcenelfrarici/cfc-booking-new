<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds "The Hub" page from its section components.
 */
class HubController extends ControllerBase {

  public function __construct(
    protected ThemeExtensionList $themeExtensionList,
    protected ContentRepository $contentRepository,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('extension.list.theme'),
      $container->get('cfc_content.repository'),
    );
  }

  /**
   * Builds the Hub page render array.
   */
  public function build(): array {
    $images_base = base_path() . $this->themeExtensionList->getPath('cfc_media_hub') . '/images';
    $home_url = Url::fromRoute('<front>')->toString();
    $spaces_url = Url::fromRoute('cfc_pages.spaces')->toString();
    $booking_base_url = Url::fromRoute('cfc_pages.booking')->toString();

    return [
      'hero' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hub-hero',
        '#props' => [
          'home_url' => $home_url,
          'spaces_url' => $spaces_url,
          'images_base' => $images_base,
        ],
      ],
      'vision_mission' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hub-vision-mission',
      ],
      'spaces_overview' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hub-spaces-overview',
        '#props' => [
          'spaces_url' => $spaces_url,
          'spaces' => $this->contentRepository->getSpaces(),
        ],
        '#cache' => ['tags' => ['node_list:space']],
      ],
      'location' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hub-location',
        '#props' => [
          'images_base' => $images_base,
        ],
      ],
      'final_cta' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hub-final-cta',
        '#props' => [
          'booking_base_url' => $booking_base_url,
        ],
      ],
    ];
  }

}
