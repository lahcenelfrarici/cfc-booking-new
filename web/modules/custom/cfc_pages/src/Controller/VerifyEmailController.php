<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_account\Form\VerifyEmailForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Post-registration "Check your inbox" email-verification page — the gate
 * between AccountRegisterForm and the booking journey (see
 * BookingController::build()).
 */
class VerifyEmailController extends ControllerBase {

  public function __construct(
    protected FormBuilderInterface $cfcFormBuilder,
    protected ThemeExtensionList $themeExtensionList,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('extension.list.theme'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build(Request $request): array|RedirectResponse {
    $user = $this->entityTypeManager()->getStorage('user')->load($this->currentUser()->id());

    if ((bool) $user->get('field_email_verified')->value) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.booking')->toString());
    }

    $email = (string) $request->query->get('email', $user->getEmail());
    $type = (string) $request->query->get('type', (string) $user->get('field_account_type')->value);

    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:verify-email-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
        'email' => $email,
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(VerifyEmailForm::class, $email, $type),
      ],
    ];
  }

}
