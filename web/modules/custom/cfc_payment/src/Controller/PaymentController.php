<?php

namespace Drupal\cfc_payment\Controller;

use Drupal\cfc_payment\Form\PaymentForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Builds the payment page — the real PaymentForm (cfc_payment module),
 * wrapped in the site's visual shell.
 */
class PaymentController extends ControllerBase {

  public function __construct(
    protected FormBuilderInterface $cfcFormBuilder,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('form_builder'));
  }

  /**
   * Builds the payment page render array.
   */
  public function build(NodeInterface $node): array|RedirectResponse {
    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:payment-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(PaymentForm::class, $node),
      ],
    ];
  }

}
