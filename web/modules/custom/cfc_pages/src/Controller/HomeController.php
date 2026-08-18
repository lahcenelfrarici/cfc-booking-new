<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the CFC Media Hub homepage from the marketing section components.
 */
class HomeController extends ControllerBase {

  public function __construct(
    protected ContentRepository $contentRepository,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('cfc_content.repository'));
  }

  /**
   * Builds the homepage render array.
   */
  public function build(): array {
    $spaces_url = Url::fromRoute('cfc_pages.spaces')->toString();
    $production_url = Url::fromRoute('cfc_pages.production')->toString();
    $booking_base_url = Url::fromRoute('cfc_pages.booking')->toString();

    return [
      'hero' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hero',
        '#props' => [
          'spaces_url' => $spaces_url,
          'production_url' => $production_url,
          'booking_base_url' => $booking_base_url,
        ],
      ],
      'spaces' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:spaces-teaser',
        '#props' => [
          'spaces_url' => $spaces_url,
          'booking_base_url' => $booking_base_url,
          'spaces' => $this->contentRepository->getSpaces(),
        ],
        '#cache' => ['tags' => ['node_list:space']],
      ],
      'productions' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:productions-section',
        '#props' => [
          'production_url' => $production_url,
          'productions' => $this->contentRepository->getProductions(5),
        ],
        '#cache' => ['tags' => ['node_list:production']],
      ],
      'ecosystem' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:ecosystem-cta',
      ],
      'final_cta' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:final-cta',
        '#props' => [
          'booking_base_url' => $booking_base_url,
        ],
      ],
    ];
  }

}
