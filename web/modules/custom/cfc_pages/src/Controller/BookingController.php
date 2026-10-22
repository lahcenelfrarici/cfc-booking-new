<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_booking\Form\BookingForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Builds the booking page — the real BookingForm (cfc_booking module),
 * wrapped in the site's visual shell.
 *
 * Requires real authentication (redirects to the real sign-in flow, exactly
 * like the Insights gate).
 */
class BookingController extends ControllerBase {

  public function __construct(
    protected RequestStack $requestStack,
    protected FormBuilderInterface $cfcFormBuilder,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('form_builder'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Builds the booking page render array.
   */
  public function build(): array|RedirectResponse {
    $request = $this->requestStack->getCurrentRequest();

    if (!$this->currentUser()->isAuthenticated()) {
      $destination = '/booking';
      if ($space = $request->query->get('space')) {
        $destination .= '?space=' . rawurlencode($space);
      }
      return new RedirectResponse(
        Url::fromRoute('cfc_pages.sign_in', [], ['query' => ['destination' => $destination]])->toString()
      );
    }

    $user = $this->cfcEntityTypeManager->getStorage('user')->load($this->currentUser()->id());
    if (!(bool) $user->get('field_email_verified')->value) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.verify_email')->toString());
    }

    $initial_space = $request->query->get('space');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:booking-form-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(BookingForm::class, $initial_space),
      ],
    ];
  }

}
