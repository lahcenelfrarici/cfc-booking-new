<?php

namespace Drupal\cfc_account\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * "Forgot password" step 2: enter the 6-digit code emailed by
 * ForgotPasswordRequestForm. On success, marks the account verified in the
 * session (consumed by ResetPasswordForm) and clears the code (one-time
 * use). Also handles "Resend code" as a second submit button on the same
 * form, so the email doesn't need re-entering.
 */
class VerifyResetCodeForm extends FormBase {

  /**
   * How long a requested code stays valid — must match
   * ForgotPasswordRequestForm::CODE_LIFETIME_MINUTES.
   */
  protected const CODE_LIFETIME_MINUTES = 15;

  /**
   * How long the "verified" session flag stays good for, once the code is
   * confirmed — just long enough to fill in the new password form.
   */
  protected const VERIFIED_LIFETIME_MINUTES = 10;

  public function __construct(
    protected RequestStack $cfcRequestStack,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_account_verify_reset_code_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?string $email = NULL): array {
    $email ??= (string) $this->cfcRequestStack->getCurrentRequest()->query->get('email');

    $form['#attributes']['class'][] = 'space-y-4';
    $form['#attributes']['x-data'] = '{ code: "" }';

    $form['email'] = [
      '#type' => 'hidden',
      '#value' => $email,
    ];

    // Six visible 1-digit boxes (Alpine), combined into the one real
    // 'code' field Drupal actually validates/submits. Bound reactively via
    // x-bind:value rather than $refs + dispatch — the digits live inside a
    // nested x-data (their own 'digits' array scope), and Alpine's $refs
    // does not reliably cross nested x-data boundaries (confirmed earlier
    // in this project, see AccountRegisterForm's account_type field);
    // plain reactive data (the outer 'code' variable) does cascade into
    // nested scopes, so x-bind:value is the reliable mechanism here too.
    $form['code'] = [
      '#type' => 'hidden',
      '#attributes' => ['x-bind:value' => 'code'],
      '#prefix' => Markup::create($this->codeDigitsMarkup()),
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Verify code'),
      '#attributes' => [
        'class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'disabled:opacity-50', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors', 'mb-5'],
        'x-bind:disabled' => 'code.length !== 6',
      ],
    ];

    // Resend + change-email, side by side — one Alpine scope (countdown)
    // wraps both so the resend button starts disabled and the seconds
    // label next to it counts down together.
    $form['bottom_row'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['flex', 'items-center', 'justify-between', 'pt-5', 'border-t', 'border-neutral-100'],
        'x-data' => '{ countdown: 60 }',
        'x-init' => 'const t = setInterval(() => { if (countdown > 0) countdown--; else clearInterval(t); }, 1000);',
      ],
    ];
    $form['bottom_row']['resend'] = [
      '#type' => 'submit',
      '#value' => $this->t('Resend code'),
      '#submit' => ['::resendSubmit'],
      '#limit_validation_errors' => [['email']],
      '#attributes' => [
        'class' => ['flex', 'items-center', 'gap-1.5', 'text-[13px]', 'font-medium', 'text-[#9F5434]', 'hover:text-[#8A4A2E]', 'disabled:text-neutral-300', 'disabled:cursor-not-allowed', 'transition-colors'],
        'x-bind:disabled' => 'countdown > 0',
      ],
      '#suffix' => Markup::create('<span class="text-[13px] text-neutral-400 ml-1" x-show="countdown > 0" x-cloak x-text="`(${countdown}s)`"></span>'),
    ];
    $form['bottom_row']['change_email'] = [
      '#markup' => Markup::create('<a href="' . Url::fromRoute('cfc_pages.forgot_password')->toString() . '" class="text-[13px] text-neutral-400 hover:text-neutral-700 underline underline-offset-2 transition-colors">Change email</a>'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    // The "Resend code" button skips this entirely via
    // #limit_validation_errors — only the real "Verify code" submit reaches
    // here.
    if ($form_state->getTriggeringElement()['#name'] === 'resend') {
      return;
    }

    $email = (string) $form_state->getValue('email');
    $code = (string) $form_state->getValue('code');
    $user = user_load_by_mail($email);

    if (!$user
      || $user->get('field_reset_code')->value === ''
      || $user->get('field_reset_code')->value !== $code
      || (int) $user->get('field_reset_code_expires')->value < \Drupal::time()->getRequestTime()
    ) {
      $form_state->setErrorByName('code', $this->t('That code is incorrect or has expired. Please request a new one.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $email = (string) $form_state->getValue('email');
    $user = user_load_by_mail($email);

    // One-time use — consumed the instant it's confirmed, so the same code
    // can't be replayed.
    $user->set('field_reset_code', '');
    $user->set('field_reset_code_expires', NULL);
    $user->save();

    $session = $this->cfcRequestStack->getCurrentRequest()->getSession();
    $session->set('cfc_reset_verified_uid', $user->id());
    $session->set('cfc_reset_verified_until', \Drupal::time()->getRequestTime() + self::VERIFIED_LIFETIME_MINUTES * 60);

    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.forgot_password_reset'));
  }

  /**
   * #submit callback for the "Resend code" button — regenerates and
   * re-sends a fresh code for the same email, same logic as
   * ForgotPasswordRequestForm::submitForm().
   */
  public function resendSubmit(array &$form, FormStateInterface $form_state): void {
    $email = (string) $form_state->getValue('email');
    $user = user_load_by_mail($email);
    if (!$user) {
      return;
    }

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

    \Drupal::logger('cfc_account')->notice('Password reset code (resent) for @email: @code (expires in @minutes min)', [
      '@email' => $email,
      '@code' => $code,
      '@minutes' => self::CODE_LIFETIME_MINUTES,
    ]);

    $this->messenger()->addStatus($this->t('A new verification code has been sent to @email.', ['@email' => $email]));
    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.forgot_password_verify', [], ['query' => ['email' => $email]]));
  }

  /**
   * Markup for the 6 single-digit boxes — typing a digit auto-advances
   * focus to the next box, backspace on an empty box moves back. All six
   * values are joined into the real hidden 'code' field on every keystroke.
   */
  protected function codeDigitsMarkup(): string {
    return <<<'HTML'
      <div class="mb-6">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-3" style="font-weight: 600;">Verification code</label>
        <div class="flex gap-2.5" x-data="{ digits: ['', '', '', '', '', ''] }" x-init="$watch('digits', (v) => { code = v.join(''); })">
          <template x-for="(d, i) in [0, 1, 2, 3, 4, 5]" :key="i">
            <input
              type="text" inputmode="numeric" maxlength="1"
              x-model="digits[i]"
              x-on:input="digits[i] = $event.target.value.replace(/[^0-9]/g, '').slice(-1); if (digits[i] && i < 5) $el.parentElement.children[i + 1].focus();"
              x-on:keydown.backspace="if (!digits[i] && i > 0) $el.parentElement.children[i - 1].focus();"
              x-on:paste="
                $event.preventDefault();
                const text = ($event.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
                if (!text) return;
                text.split('').forEach((ch, j) => { if (i + j < 6) digits[i + j] = ch; });
                $nextTick(() => $el.parentElement.children[Math.min(i + text.length, 5)].focus());
              "
              class="flex-1 min-w-0 h-14 border border-neutral-200 rounded-xl text-center text-neutral-900 bg-white focus:outline-none focus:border-[#9F5434] focus:ring-2 focus:ring-[#9F5434]/15 transition-colors"
              style="font-size: 22px; font-weight: 600;"
            />
          </template>
        </div>
      </div>
      HTML;
  }

}
