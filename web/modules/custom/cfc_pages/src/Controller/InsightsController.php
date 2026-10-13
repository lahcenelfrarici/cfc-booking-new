<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_connections\Form\ConnectionRequestForm;
use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Builds the Insights page — gated teaser for anonymous users, full
 * knowledge center for authenticated users.
 */
class InsightsController extends ControllerBase {

  public function __construct(
    protected ContentRepository $contentRepository,
    protected RequestStack $cfcRequestStack,
  ) {}

  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cfc_content.repository'),
      $container->get('request_stack'),
    );
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
        'categories' => $this->contentRepository->getInsightCategories(),
        'initial_query' => (string) $this->cfcRequestStack->getCurrentRequest()->query->get('q', ''),
        'connection_form' => $this->formBuilder()->getForm(ConnectionRequestForm::class),
      ],
      '#cache' => [
        'contexts' => ['user.roles:authenticated', 'url.query_args:q'],
        'tags' => ['node_list:insight_document'],
      ],
    ];
  }

}
