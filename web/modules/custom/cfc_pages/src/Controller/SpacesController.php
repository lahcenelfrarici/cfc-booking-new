<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the Spaces page from its section components.
 */
class SpacesController extends ControllerBase {

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
   * Builds the Spaces page render array.
   */
  public function build(): array {
    // Only the Studio Equipment section's illustrative photo is theme-owned
    // (it's not a per-Space field, just a fixed section image).
    $images_base = base_path() . $this->themeExtensionList->getPath('cfc_media_hub') . '/images';
    $home_url = Url::fromRoute('<front>')->toString();
    $booking_base_url = Url::fromRoute('cfc_pages.booking')->toString();

    return [
      'hero' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:spaces-hero',
        '#props' => [
          'home_url' => $home_url,
        ],
      ],
      'comparison' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:spaces-comparison',
        '#props' => [
          'booking_base_url' => $booking_base_url,
          'spaces' => $this->contentRepository->getSpaces(),
        ],
        '#cache' => ['tags' => ['node_list:space']],
      ],
      'equipment' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:studio-equipment',
        '#props' => [
          'images_base' => $images_base,
        ],
      ],
      'how_it_works' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:how-it-works',
      ],
      'final_cta' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:spaces-final-cta',
        '#props' => [
          'booking_base_url' => $booking_base_url,
        ],
      ],
    ];
  }

}
