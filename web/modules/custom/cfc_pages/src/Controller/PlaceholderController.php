<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Routing\RouteMatchInterface;

/**
 * Temporary controller for pages not yet built out.
 */
class PlaceholderController extends ControllerBase {

  /**
   * Builds a minimal "coming soon" page using the design system tokens.
   */
  public function build(RouteMatchInterface $route_match): array {
    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:placeholder-page',
      '#props' => [
        'title' => $route_match->getRouteObject()->getDefault('_title'),
      ],
    ];
  }

}
