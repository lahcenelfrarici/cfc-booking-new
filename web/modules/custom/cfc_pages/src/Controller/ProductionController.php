<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the Production/Ecosystem page.
 */
class ProductionController extends ControllerBase {

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
   * Builds the Production page render array.
   */
  public function build(): array {
    return [
      'produced_by_hub' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:produced-by-hub',
        '#props' => [
          'insights_url' => Url::fromRoute('cfc_pages.insights')->toString(),
          'productions' => $this->contentRepository->getProductions(),
        ],
        '#cache' => ['tags' => ['node_list:production']],
      ],
    ];
  }

}
