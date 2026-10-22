<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_account\Form\ForgotPasswordRequestForm;
use Drupal\cfc_account\Form\ResetPasswordForm;
use Drupal\cfc_account\Form\VerifyResetCodeForm;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Form\FormBuilderInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Wraps the "Forgot password" flow's three real forms (request code, verify
 * code, set new password) plus a static confirmation step, each in the
 * site's visual shell.
 */
class ForgotPasswordController extends ControllerBase {

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
   * Step 1: request a code by email.
   */
  public function build(): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }

    return $this->shell('forgot-password-page', $this->cfcFormBuilder->getForm(ForgotPasswordRequestForm::class));
  }

  /**
   * Step 2: enter the code that was emailed.
   */
  public function verify(Request $request): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }
    $email = (string) $request->query->get('email');
    if (!$email || !user_load_by_mail($email)) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.forgot_password')->toString());
    }

    return $this->shell('forgot-password-verify-page', $this->cfcFormBuilder->getForm(VerifyResetCodeForm::class, $email), ['email' => $email]);
  }

  /**
   * Step 3: set a new password — only reachable right after a successful
   * code verification (see ResetPasswordForm::verifiedUid()).
   */
  public function reset(): array|RedirectResponse {
    if ($this->currentUser()->isAuthenticated()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.account')->toString());
    }
    $form_object = $this->classResolver(ResetPasswordForm::class);
    if (!$form_object->verifiedUid()) {
      return new RedirectResponse(Url::fromRoute('cfc_pages.forgot_password')->toString());
    }

    return $this->shell('forgot-password-reset-page', $this->cfcFormBuilder->getForm($form_object));
  }

  /**
   * Step 4: static "Password updated." confirmation.
   */
  public function done(): array {
    return $this->shell('forgot-password-done-page', NULL);
  }

  /**
   * Builds the shared render array (logo + card shell + sign_in_url +
   * optional form slot) for any step of this flow.
   */
  protected function shell(string $component, mixed $form, array $extra_props = []): array {
    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');

    $build = [
      '#type' => 'component',
      '#component' => "cfc_media_hub:$component",
      '#props' => $extra_props + [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'sign_in_url' => Url::fromRoute('cfc_pages.sign_in')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
      ],
    ];
    if ($form !== NULL) {
      $build['#slots']['form'] = $form;
    }
    return $build;
  }

  /**
   * Thin wrapper around \Drupal::classResolver() — ControllerBase doesn't
   * expose the class resolver service directly.
   */
  protected function classResolver(string $class): object {
    return \Drupal::classResolver($class);
  }

}
