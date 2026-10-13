<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Builds the public "News" page (All / News / Events / Updates / Agenda).
 */
class NewsController extends ControllerBase {

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
   * Builds the News listing page render array.
   */
  public function build(): array {
    return [
      'news_listing' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:news-listing',
        '#props' => [
          'items' => $this->contentRepository->getNewsItems(),
          'home_url' => Url::fromRoute('<front>')->toString(),
        ],
        '#cache' => ['tags' => ['node_list:news_item']],
      ],
    ];
  }

  /**
   * Builds the single News item detail page render array.
   */
  public function detail(NodeInterface $node): array {
    $item = $this->contentRepository->getNewsItem((int) $node->id());
    if (!$item) {
      throw new NotFoundHttpException();
    }

    return [
      'news_detail' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:news-detail',
        '#props' => [
          'item' => $item,
          'news_url' => Url::fromRoute('cfc_pages.news')->toString(),
        ],
        '#cache' => ['tags' => ['node:' . $node->id()]],
      ],
    ];
  }

  /**
   * Title callback for the News detail page.
   */
  public function detailTitle(NodeInterface $node): string {
    return $node->label();
  }

}
