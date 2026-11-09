<?php

namespace Drupal\cfc_account\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * Post-registration "Check your inbox" step: enter the 6-digit code emailed
 * by AccountRegisterForm. Same mechanics as the "forgot password" code flow
 * (VerifyResetCodeForm) — 60s resend cooldown, one-time code — but gates
 * entry into the booking journey (BookingController::build()) instead of a
 * password reset.
 */
class VerifyEmailForm extends FormBase {

  /**
   * How long a requested code stays valid — must match the value used in
   * AccountRegisterForm::submitForm() and resendSubmit() below.
   */
  public const CODE_LIFETIME_MINUTES = 15;

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
    return 'cfc_account_verify_email_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?string $email = NULL, ?string $type = NULL): array {
    $query = $this->cfcRequestStack->getCurrentRequest()->query;
    $email ??= (string) $query->get('email');
    $type ??= (string) $query->get('type');
    $just_resent = (bool) $query->get('resent');

    $form['#attributes']['class'][] = 'space-y-0';
    $form['#attributes']['x-data'] = '{ code: "" }';

    $form['email'] = ['#type' => 'hidden', '#value' => $email];
    $form['type'] = ['#type' => 'hidden', '#value' => $type];

    // Six visible 1-digit boxes (Alpine), combined into the one real 'code'
    // field — same x-bind:value pattern as VerifyResetCodeForm (Alpine's
    // $refs doesn't reliably cross nested x-data boundaries; plain reactive
    // data does).
    $form['code'] = [
      '#type' => 'hidden',
      '#attributes' => ['x-bind:value' => 'code'],
      '#prefix' => Markup::create($this->codeDigitsMarkup()),
    ];

    // The "Didn't receive it?" box — resend (with its own 60s cooldown,
    // flipping to a "resent" label while counting down) and change-email,
    // matching the pasted Figma design exactly.
    $form['receive_box'] = [
      '#type' => 'container',
      '#attributes' => [
        'class' => ['bg-white', 'border', 'border-neutral-200', 'rounded-3xl', 'p-8', 'text-left', 'space-y-4', 'mb-8'],
        'x-data' => '{ countdown: ' . ($just_resent ? 60 : 0) . ' }',
        'x-init' => 'if (countdown > 0) { const t = setInterval(() => { if (countdown > 0) countdown--; else clearInterval(t); }, 1000); }',
      ],
    ];
    $form['receive_box']['label'] = [
      '#markup' => Markup::create('<div class="text-[12px] uppercase tracking-wide text-neutral-400 mb-2" style="font-weight: 600;">' . $this->t("Didn't receive it?") . '</div>'),
    ];
    $form['receive_box']['resend_done'] = [
      '#type' => 'submit',
      '#value' => $this->t('Verification email resent ✓'),
      '#submit' => ['::resendSubmit'],
      '#limit_validation_errors' => [['email'], ['type']],
      '#attributes' => [
        'disabled' => 'disabled',
        'class' => ['w-full', 'flex', 'items-center', 'justify-between', 'border', 'border-neutral-200', 'rounded-2xl', 'px-5', 'py-4', 'transition-colors', 'group'],
      ],
      '#prefix' => Markup::create('<template x-if="countdown > 0">'),
      '#suffix' => Markup::create('</template><template x-if="countdown === 0">'),
    ];
    // A second button covers the normal, enabled state — swapped in by the
    // two <template x-if> wrappers above/below rather than toggling classes
    // on one element, since the icon itself needs to disappear once resent,
    // not just grey out.
    $form['receive_box']['resend'] = [
      '#type' => 'submit',
      '#value' => $this->t('Resend verification email'),
      '#submit' => ['::resendSubmit'],
      '#limit_validation_errors' => [['email'], ['type']],
      '#attributes' => [
        'class' => ['w-full', 'flex', 'items-center', 'justify-between', 'border', 'border-neutral-200', 'hover:border-[#9F5434]/40', 'hover:bg-[#9F5434]/5', 'rounded-2xl', 'px-5', 'py-4', 'transition-colors', 'group'],
      ],
      '#suffix' => Markup::create('</template>'),
    ];
    $form['receive_box']['change_email'] = [
      '#type' => 'submit',
      '#value' => $this->t('Change email address'),
      '#submit' => ['::changeEmailSubmit'],
      '#limit_validation_errors' => [['email'], ['type']],
      '#attributes' => [
        'class' => ['w-full', 'flex', 'items-center', 'justify-between', 'border', 'border-neutral-200', 'hover:border-neutral-400', 'rounded-2xl', 'px-5', 'py-4', 'transition-colors', 'group'],
      ],
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t("I've verified my email — Continue"),
      '#attributes' => [
        'class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'disabled:opacity-50', 'text-white', 'py-4', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors'],
        'x-bind:disabled' => 'code.length !== 6',
      ],
    ];

    $form['expiry_note'] = [
      '#markup' => Markup::create('<p class="mt-4 text-[12px] text-neutral-400">' . $this->t('The verification code expires in @minutes minutes.', ['@minutes' => self::CODE_LIFETIME_MINUTES]) . '</p>'),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $trigger = $form_state->getTriggeringElement()['#name'] ?? '';
    if (in_array($trigger, ['resend', 'resend_done', 'change_email'], TRUE)) {
      return;
    }

    $email = (string) $form_state->getValue('email');
    $code = (string) $form_state->getValue('code');
    $user = user_load_by_mail($email);

    if (!$user
      || $user->get('field_verify_code')->value === ''
      || $user->get('field_verify_code')->value !== $code
      || (int) $user->get('field_verify_code_expires')->value < \Drupal::time()->getRequestTime()
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

    $user->set('field_verify_code', '');
    $user->set('field_verify_code_expires', NULL);
    $user->set('field_email_verified', TRUE);
    $user->save();

    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.booking'));
  }

  /**
   * #submit callback for "Resend verification email" — regenerates and
   * re-sends a fresh code for the same email, same logic as
   * AccountRegisterForm::submitForm().
   */
  public function resendSubmit(array &$form, FormStateInterface $form_state): void {
    $email = (string) $form_state->getValue('email');
    $type = (string) $form_state->getValue('type');
    $user = user_load_by_mail($email);
    if (!$user) {
      return;
    }

    $code = (string) random_int(100000, 999999);
    $expires = \Drupal::time()->getRequestTime() + self::CODE_LIFETIME_MINUTES * 60;
    $user->set('field_verify_code', $code);
    $user->set('field_verify_code_expires', $expires);
    $user->save();

    \Drupal::service('plugin.manager.mail')->mail(
      'cfc_account',
      'verify_code',
      $email,
      \Drupal::languageManager()->getDefaultLanguage()->getId(),
      ['code' => $code, 'minutes' => self::CODE_LIFETIME_MINUTES],
    );

    \Drupal::logger('cfc_account')->notice('Email verification code (resent) for @email: @code (expires in @minutes min)', [
      '@email' => $email,
      '@code' => $code,
      '@minutes' => self::CODE_LIFETIME_MINUTES,
    ]);

    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.verify_email', [], ['query' => ['email' => $email, 'type' => $type, 'resent' => 1]]));
  }

  /**
   * #submit callback for "Change email address" — logs the half-registered
   * (unverified) account out and sends the user back to the registration
   * form, pre-selected to whichever account type they originally chose, so
   * they can redo registration with the correct email. The now-orphaned
   * unverified account is left as-is rather than deleted.
   */
  public function changeEmailSubmit(array &$form, FormStateInterface $form_state): void {
    $type = (string) $form_state->getValue('type');
    user_logout();
    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.register', [], ['query' => ['type' => $type]]));
  }

  /**
   * Markup for the 6 single-digit boxes — identical mechanics to
   * VerifyResetCodeForm::codeDigitsMarkup(), positioned here just above the
   * "Didn't receive it?" box per the Figma design.
   */
  protected function codeDigitsMarkup(): string {
    return <<<'HTML'
      <div class="mb-8">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-3 text-center" style="font-weight: 600;">Verification code</label>
        <div class="flex gap-1.5 sm:gap-2.5 justify-center" x-data="{ digits: ['', '', '', '', '', ''] }" x-init="$watch('digits', (v) => { code = v.join(''); })">
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
              class="w-10 h-10 sm:w-12 sm:h-12 md:w-14 md:h-14 border border-neutral-200 rounded-xl text-center text-neutral-900 bg-white focus:outline-none focus:border-[#9F5434] focus:ring-2 focus:ring-[#9F5434]/15 transition-colors text-[17px] md:text-[22px] font-semibold"
            />
          </template>
        </div>
      </div>
      HTML;
  }

}
