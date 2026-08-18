<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\user\Form\UserLoginForm;
use Drupal\user\Form\UserPasswordForm;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Builds the sign-in page, wrapping Drupal core's real login/password-reset
 * forms (for genuine authentication) in the custom design.
 */
class SignInController extends ControllerBase {

  public function __construct(
    protected FormBuilderInterface $cfcFormBuilder,
    protected RequestStack $requestStack,
    protected ThemeExtensionList $themeExtensionList,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('form_builder'),
      $container->get('request_stack'),
      $container->get('extension.list.theme'),
    );
  }

  /**
   * Builds the sign-in page render array.
   */
  public function build(): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    $destination = $this->requestStack->getCurrentRequest()->query->get('destination');
    $query = $destination ? ['destination' => $destination] : [];

    $login_form = $this->cfcFormBuilder->getForm(UserLoginForm::class);
    $password_form = $this->cfcFormBuilder->getForm(UserPasswordForm::class);
    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:sign-in-page',
      '#props' => [
        'login_action' => Url::fromRoute('user.login', [], ['query' => $query])->toString(),
        'login_form_build_id' => $login_form['form_build_id']['#value'],
        'password_action' => Url::fromRoute('user.pass', [], ['query' => $query])->toString(),
        'password_form_build_id' => $password_form['form_build_id']['#value'],
        'create_account_url' => Url::fromRoute('cfc_pages.register', [], ['query' => $query])->toString(),
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
      ],
    ];
  }

}
