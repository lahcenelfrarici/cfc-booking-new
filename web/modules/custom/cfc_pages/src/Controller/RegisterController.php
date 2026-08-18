<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_account\Form\AccountRegisterForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Wraps the real AccountRegisterForm in the site's visual shell.
 */
class RegisterController extends ControllerBase {

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
   * Builds the registration page render array.
   */
  public function build(): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:register-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'sign_in_url' => Url::fromRoute('cfc_pages.sign_in')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
      ],
      '#slots' => [
        'form' => $this->cfcFormBuilder->getForm(AccountRegisterForm::class),
      ],
    ];
  }

}
