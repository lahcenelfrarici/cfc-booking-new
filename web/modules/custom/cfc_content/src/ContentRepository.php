<?php

namespace Drupal\cfc_content;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Drupal\file\FileInterface;
use Drupal\node\NodeInterface;

/**
 * Loads Space and Production nodes as plain arrays for the theme components.
 */
class ContentRepository {

  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Returns all Space nodes, ordered by field_weight, as plain arrays.
   */
  public function getSpaces(): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'space')
      ->condition('status', 1)
      ->sort('field_weight', 'ASC')
      ->accessCheck(TRUE)
      ->execute();

    $spaces = [];
    foreach ($storage->loadMultiple($ids) as $node) {
      $spaces[] = $this->mapSpace($node);
    }
    return $spaces;
  }

  /**
   * Returns a single Space by its machine key (e.g. "studio"), or NULL.
   */
  public function getSpaceByKey(string $key): ?array {
    foreach ($this->getSpaces() as $space) {
      if ($space['id'] === $key) {
        return $space;
      }
    }
    return NULL;
  }

  /**
   * Returns Production nodes, ordered by field_weight, as plain arrays.
   *
   * @param int|null $limit
   *   Maximum number of productions to return, or NULL for all.
   */
  public function getProductions(?int $limit = NULL): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', 'production')
      ->condition('status', 1)
      ->sort('field_weight', 'ASC')
      ->accessCheck(TRUE);
    if ($limit) {
      $query->range(0, $limit);
    }
    $ids = $query->execute();

    $productions = [];
    foreach ($storage->loadMultiple($ids) as $node) {
      $productions[] = $this->mapProduction($node);
    }
    return $productions;
  }

  /**
   * Returns a single published Production node by id, mapped as a plain
   * array, or NULL if it doesn't exist, isn't published, or isn't a
   * Production.
   */
  public function getProduction(int $id): ?array {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    if (!$node instanceof NodeInterface || $node->bundle() !== 'production' || !$node->isPublished()) {
      return NULL;
    }
    return $this->mapProduction($node);
  }

  /**
   * Returns News item nodes, ordered by field_weight then date (newest
   * first), as plain arrays.
   */
  public function getNewsItems(): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'news_item')
      ->condition('status', 1)
      ->sort('field_weight', 'ASC')
      ->sort('field_news_date', 'DESC')
      ->accessCheck(TRUE)
      ->execute();

    $items = [];
    foreach ($storage->loadMultiple($ids) as $node) {
      $items[] = $this->mapNewsItem($node);
    }
    return $items;
  }

  /**
   * Returns a single published News item by id, or NULL.
   */
  public function getNewsItem(int $id): ?array {
    $node = $this->entityTypeManager->getStorage('node')->load($id);
    if (!$node instanceof NodeInterface || $node->bundle() !== 'news_item' || !$node->isPublished()) {
      return NULL;
    }
    return $this->mapNewsItem($node);
  }

  /**
   * Returns Insight documents grouped by category, matching the shape the
   * insights-content component expects: an ordered list of
   * {id, label, icon, documents: [...]}, each document carrying id, title,
   * date, pages, tag and pdf_url.
   */
  public function getInsightCategories(): array {
    $category_labels = [
      'cfc-africa-insights' => 'CFC Africa Insights Reports',
      'community' => 'Community Reports',
      'country-focus' => 'Country Focus',
      'africa-news' => 'Africa News',
      'sector-notes' => 'Sector Notes',
      'ifc-impact' => 'Study on the Impact of International Financial Centers',
    ];
    $category_icons = [
      'cfc-africa-insights' => 'bar-chart-2',
      'community' => 'layers',
      'country-focus' => 'earth',
      'africa-news' => 'newspaper',
      'sector-notes' => 'file-text',
      'ifc-impact' => 'building',
    ];

    $storage = $this->entityTypeManager->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'insight_document')
      ->condition('status', 1)
      ->sort('field_weight', 'ASC')
      ->accessCheck(TRUE)
      ->execute();

    $by_category = array_fill_keys(array_keys($category_labels), []);
    foreach ($storage->loadMultiple($ids) as $node) {
      $category = (string) $node->get('field_insight_category')->value;
      if (!isset($by_category[$category])) {
        continue;
      }
      $date_value = $node->get('field_insight_date')->value;
      $by_category[$category][] = [
        'id' => (int) $node->id(),
        'title' => $node->label(),
        'date' => $date_value ? (new \DateTime($date_value))->format('F Y') : '',
        'pages' => (string) $node->get('field_pages')->value,
        'tag' => $node->get('field_insight_tag')->value ?: NULL,
        'pdf_url' => $this->fieldImageUrl($node, 'field_pdf'),
      ];
    }

    $categories = [];
    foreach ($category_labels as $id => $label) {
      if (!$by_category[$id]) {
        continue;
      }
      $categories[] = [
        'id' => $id,
        'label' => $label,
        'icon' => $category_icons[$id],
        'documents' => $by_category[$id],
      ];
    }
    return $categories;
  }

  /**
   * Maps a News item node to a plain array matching the component props shape.
   */
  protected function mapNewsItem(NodeInterface $node): array {
    $date_value = $node->get('field_news_date')->value;
    return [
      'id' => (int) $node->id(),
      'title' => $node->label(),
      'category' => (string) $node->get('field_news_category')->value,
      'date' => $date_value ? (new \DateTime($date_value))->format('F Y') : '',
      'summary' => (string) $node->get('field_summary')->value,
      'image_url' => $this->fieldImageUrl($node, 'field_image'),
      'url' => Url::fromRoute('cfc_pages.news_detail', ['node' => $node->id()])->toString(),
    ];
  }

  /**
   * Maps a Space node to a plain array matching the component props shape.
   */
  protected function mapSpace(NodeInterface $node): array {
    return [
      'id' => (string) $node->get('field_machine_key')->value,
      'nid' => (int) $node->id(),
      'title' => $node->label(),
      'subtitle' => (string) $node->get('field_subtitle')->value,
      'summary' => (string) $node->get('field_summary')->value,
      'description' => (string) $node->get('field_description')->value,
      'price_label' => (string) $node->get('field_price_label')->value,
      'capacity_meta' => (string) $node->get('field_capacity_meta')->value,
      'access_rule' => (string) $node->get('field_access_rule')->value,
      'highlight' => (bool) $node->get('field_highlight')->value,
      'features' => array_map(static function ($item) {
        [$icon, $title, $subtitle] = array_pad(explode('|', (string) $item->value, 3), 3, '');
        return ['icon' => $icon, 'title' => $title, 'subtitle' => $subtitle];
      }, iterator_to_array($node->get('field_features'))),
      'teaser_features' => array_map(static fn($item) => $item->value, iterator_to_array($node->get('field_teaser_features'))),
      'meta1_label' => (string) $node->get('field_meta1_label')->value,
      'meta1_value' => (string) $node->get('field_meta1_value')->value,
      'meta2_label' => (string) $node->get('field_meta2_label')->value,
      'meta2_value' => (string) $node->get('field_meta2_value')->value,
      'slot_durations' => array_map(static fn($item) => $item->value, iterator_to_array($node->get('field_slot_durations'))),
      'max_guests' => (int) $node->get('field_max_guests')->value,
      'cta_label' => (string) $node->get('field_cta_label')->value,
      'image_url' => $this->fieldImageUrl($node, 'field_hero_image'),
      'hourly_rate' => (float) $node->get('field_hourly_rate')->value,
      'currency' => (string) ($node->get('field_currency')->value ?: 'EUR'),
    ];
  }

  /**
   * Maps a Production node to a plain array matching the component props shape.
   */
  protected function mapProduction(NodeInterface $node): array {
    $date_value = $node->get('field_production_date')->value;
    $formatted_date = '';
    if ($date_value) {
      $formatted_date = (new \DateTime($date_value))->format('F Y');
    }

    return [
      'id' => (int) $node->id(),
      'title' => $node->label(),
      'type' => (string) $node->get('field_production_type')->value,
      'publisher' => (string) $node->get('field_publisher')->value,
      'duration' => (string) $node->get('field_duration')->value,
      'date' => $formatted_date,
      'featured' => (bool) $node->get('field_featured')->value,
      'description' => (string) $node->get('field_description')->value,
      'image_url' => $this->fieldImageUrl($node, 'field_image'),
      'url' => Url::fromRoute('cfc_pages.production_detail', ['node' => $node->id()])->toString(),
    ];
  }

  /**
   * Returns the absolute URL for an image field, or NULL if empty.
   */
  protected function fieldImageUrl(NodeInterface $node, string $field_name): ?string {
    if ($node->get($field_name)->isEmpty()) {
      return NULL;
    }
    /** @var \Drupal\file\FileInterface|null $file */
    $file = $node->get($field_name)->entity;
    if (!$file instanceof FileInterface) {
      return NULL;
    }
    return \Drupal::service('file_url_generator')->generateAbsoluteString($file->getFileUri());
  }

}
