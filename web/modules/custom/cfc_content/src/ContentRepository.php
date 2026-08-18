<?php

namespace Drupal\cfc_content;

use Drupal\Core\Entity\EntityTypeManagerInterface;
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
      'features' => array_map(static fn($item) => $item->value, iterator_to_array($node->get('field_features'))),
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
      'image_url' => $this->fieldImageUrl($node, 'field_image'),
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
