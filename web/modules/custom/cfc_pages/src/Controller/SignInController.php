<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Drupal\user\Form\UserLoginForm;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Builds the sign-in page, wrapping Drupal core's real login form (for
 * genuine authentication) in the custom design. "Forgot password?" links out
 * to the separate forgot-password-page (6-digit code flow, not core's
 * link-based UserPasswordForm).
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
   * Builds the sign-in page render array. Also the controller for the
   * ALTERED core user.login route (see RouteSubscriber) — anything that
   * sends an anonymous visitor there (e.g. an access-denied redirect with
   * ?destination=...) renders this same themed page directly instead of
   * core's unstyled form, rather than issuing a redirect to it (a
   * RedirectResponse here would get its target silently rewritten by core
   * whenever ?destination=... is present, bypassing this page entirely).
   */
  public function build(): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    $destination = $this->requestStack->getCurrentRequest()->query->get('destination');
    $query = $destination ? ['destination' => $destination] : [];

    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:sign-in-page',
      '#props' => [
        'create_account_url' => Url::fromRoute('cfc_pages.register', [], ['query' => $query])->toString(),
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
      ],
      '#slots' => [
        // Rendering the real form object (not a hand-copied markup
        // reconstruction posting straight to /user/login) means a failed
        // login re-displays correctly inside this themed page — see
        // cfc_account_form_user_login_form_alter() for the styling/markup
        // this relies on (Forgot-password link, show/hide toggle, classes).
        'form' => $this->cfcFormBuilder->getForm(UserLoginForm::class),
      ],
    ];
  }

}
