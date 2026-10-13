<?php

namespace Drupal\cfc_account\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * "Forgot password" step 1: collects the account email and sends a 6-digit
 * verification code. Step 2 (entering that code + choosing a new password)
 * doesn't exist yet — redirects to /sign-in with a status message in the
 * meantime. Deliberately a custom code-based flow rather than Drupal core's
 * UserPasswordForm (link-based) — matches the Figma design this was built
 * from, and the same code pattern already used for registration email
 * verification.
 */
class ForgotPasswordRequestForm extends FormBase {

  protected const INPUT_CLASSES = ['w-full', 'border', 'border-neutral-200', 'rounded-xl', 'px-4', 'py-3', 'text-[14px]', 'text-neutral-900', 'bg-white', 'focus:outline-none', 'focus:border-[#9F5434]', 'transition-colors'];

  /**
   * How long a requested code stays valid.
   */
  protected const CODE_LIFETIME_MINUTES = 15;

  public function __construct(
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_account_forgot_password_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#attributes']['class'][] = 'space-y-4';
    // x-data here (not a shared shell) since this form has nothing else on
    // the page needing the same Alpine scope — just the disabled-until-filled
    // submit button, mirrored from the registration/connection forms' style.
    $form['#attributes']['x-data'] = '{ email: "" }';

    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email Address'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => self::INPUT_CLASSES,
        'placeholder' => 'you@media.org',
        'x-model' => 'email',
      ],
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Send verification code'),
      '#attributes' => [
        'class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'disabled:opacity-50', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors'],
        'x-bind:disabled' => '!email',
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $email = (string) $form_state->getValue('email');
    if (!user_load_by_mail($email)) {
      $form_state->setErrorByName('email', $this->t('No account found with this email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $email = (string) $form_state->getValue('email');
    $user = user_load_by_mail($email);

    $code = (string) random_int(100000, 999999);
    $expires = \Drupal::time()->getRequestTime() + self::CODE_LIFETIME_MINUTES * 60;

    $user->set('field_reset_code', $code);
    $user->set('field_reset_code_expires', $expires);
    $user->save();

    \Drupal::service('plugin.manager.mail')->mail(
      'cfc_account',
      'reset_code',
      $email,
      \Drupal::languageManager()->getDefaultLanguage()->getId(),
      ['code' => $code, 'minutes' => self::CODE_LIFETIME_MINUTES],
    );

    // Local dev has no SMTP/mail-catcher configured yet, so the email above
    // may not land anywhere visible — logging the code here is the only way
    // to actually test this flow until that's set up. Remove once real mail
    // delivery is confirmed working end-to-end.
    \Drupal::logger('cfc_account')->notice('Password reset code for @email: @code (expires in @minutes min)', [
      '@email' => $email,
      '@code' => $code,
      '@minutes' => self::CODE_LIFETIME_MINUTES,
    ]);

    // No code-entry screen yet — park on sign-in with a status message until
    // that page exists, same destination core's UserPasswordForm redirects
    // to after its own (link-based) reset email.
    $this->messenger()->addStatus($this->t('A verification code has been sent to @email.', ['@email' => $email]));
    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.sign_in'));
  }

}
