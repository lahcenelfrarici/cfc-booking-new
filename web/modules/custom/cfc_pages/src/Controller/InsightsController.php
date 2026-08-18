<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the Insights page — gated teaser for anonymous users, full
 * knowledge center for authenticated users.
 */
class InsightsController extends ControllerBase {

  public static function create(ContainerInterface $container) {
    return new static();
  }

  /**
   * Builds the Insights page render array.
   */
  public function build(): array {
    if (!$this->currentUser()->isAuthenticated()) {
      return [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:insights-gate',
        '#props' => [
          'sign_in_url' => Url::fromRoute('cfc_pages.sign_in', [], [
            'query' => ['destination' => '/insights'],
          ])->toString(),
        ],
        '#cache' => ['contexts' => ['user.roles:authenticated']],
      ];
    }

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:insights-content',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
      ],
      '#cache' => ['contexts' => ['user.roles:authenticated']],
    ];
  }

}
