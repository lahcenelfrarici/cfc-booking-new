<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
          'productions' => $this->contentRepository->getProductions(),
        ],
        '#cache' => ['tags' => ['node_list:production']],
      ],
    ];
  }

  /**
   * Builds the single Production detail page render array.
   */
  public function detail(NodeInterface $node): array {
    $production = $this->contentRepository->getProduction((int) $node->id());
    if (!$production) {
      throw new NotFoundHttpException();
    }

    return [
      'production_detail' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:production-detail',
        '#props' => [
          'production' => $production,
          'production_url' => Url::fromRoute('cfc_pages.production')->toString(),
        ],
        '#cache' => ['tags' => ['node:' . $node->id()]],
      ],
    ];
  }

  /**
   * Title callback for the Production detail page.
   */
  public function detailTitle(NodeInterface $node): string {
    return $node->label();
  }

}
