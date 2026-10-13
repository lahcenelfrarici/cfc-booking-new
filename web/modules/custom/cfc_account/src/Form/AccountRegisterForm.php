<?php

namespace Drupal\cfc_account\Form;

use Drupal\cfc_account\CompanyDomainMatcher;
use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Single-page registration form for Journalist and CFC Member accounts.
 *
 * Deliberately not a multistep wizard: one form, conditional fields via
 * #states, one validateForm()/submitForm() pair. See the account/booking
 * MVP plan for the reasoning.
 */
class AccountRegisterForm extends FormBase {

  protected const INPUT_CLASSES = ['w-full', 'border', 'border-neutral-200', 'rounded-xl', 'px-4', 'py-3', 'text-[14px]', 'text-neutral-900', 'bg-white', 'focus:outline-none', 'focus:border-[#9F5434]'];
  protected const LABEL_CLASSES = ['text-[12px]', 'text-neutral-600', 'uppercase', 'tracking-wide', 'font-semibold', 'block', 'mb-1.5'];

  public function __construct(
    protected CompanyDomainMatcher $domainMatcher,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cfc_account.domain_matcher'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_account_register_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#attributes']['class'][] = 'space-y-5';

    // Driven by the card selector in register-page.twig, which sets the
    // outer `type` Alpine variable on click. Bound reactively here via
    // x-bind:value rather than a one-time $refs write — this field lives
    // inside the nested cfc-form-shell x-data (see {{ form }} in
    // register-page.twig), and Alpine's $refs does NOT cross nested x-data
    // boundaries (confirmed: a card click in the outer scope writing via
    // $refs.accountTypeField silently resolved to undefined, leaving this
    // field stuck on its default and misrouting CFC Member submissions
    // through the journalist validation branch). Plain reactive data DOES
    // cascade into nested x-data scopes, so x-bind:value="type" is reliable
    // where $refs was not. Visibility of the type-specific sections below
    // also uses x-show reading this same `type` variable, not Drupal
    // #states — #states doesn't reliably react to a dispatched 'change'
    // event on a hidden input either (confirmed separately).
    $form['account_type'] = [
      '#type' => 'hidden',
      '#default_value' => 'journalist',
      '#attributes' => ['x-bind:value' => 'type'],
    ];

    // Journalist-only fields.
    $form['journalist_fields'] = [
      '#type' => 'container',
      '#attributes' => ['x-show' => "type === 'journalist'"],
    ];
    $form['journalist_fields']['accreditation_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Accreditation number'),
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'e.g. MA-PRESS-2025-XXXX'],
    ];
    $form['journalist_fields']['passport_number'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Passport number'),
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'Passport number'],
    ];
    $form['journalist_fields']['organization'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Media organisation'),
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'Publication or media outlet'],
    ];

    // CFC Member-only fields.
    // No <select> at all — the company list lives in exactly one place
    // (the JSON embedded in the search widget below) and this field is a
    // plain hidden input the widget writes "tid|domain" into (same format
    // as before — parseCompanyTid() below is unchanged). #prefix keeps the
    // widget exactly where cfc_company would render, staying inside the
    // real <form> (printing fields individually in Twig instead dropped
    // the <form> wrapper entirely — learned that one the hard way).
    // Markup::create() marks both blocks as pre-trusted so Drupal's render
    // pipeline doesn't run them through Xss::filter() — that regex-based
    // sanitizer doesn't understand Alpine's `x-data="{ ... }"` syntax and
    // mangles it (strips <label>/<template>, corrupts attribute values).
    $form['cfc_fields'] = [
      '#type' => 'container',
      '#attributes' => ['x-show' => "type === 'cfc_member'", 'x-cloak' => TRUE],
    ];
    $form['cfc_fields']['cfc_notice'] = [
      '#markup' => Markup::create($this->cfcNoticeMarkup()),
    ];
    $companies = $this->cfcEntityTypeManager->getStorage('taxonomy_term')->loadTree('cfc_member_companies', 0, 1, TRUE);
    $company_data = array_map(static fn($term) => [
      'id' => (string) $term->id(),
      'name' => $term->label(),
      'domain' => (string) $term->get('field_company_domain')->value,
    ], $companies);
    $form['cfc_fields']['cfc_company'] = [
      '#type' => 'hidden',
      // A hidden field has no visual presence — the widget itself (in
      // #prefix) carries the x-show that controls the manual-entry field.
      '#attributes' => ['x-ref' => 'cfcCompanyField'],
      '#prefix' => Markup::create($this->companySearchWidgetMarkup(Json::encode($company_data))),
    ];
    $form['cfc_fields']['manual_organization'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Organisation name'),
      '#attributes' => [
        'class' => self::INPUT_CLASSES,
        'placeholder' => 'Enter your organisation',
        'x-show' => 'manualCompany',
        'x-cloak' => TRUE,
      ],
    ];

    // Common fields.
    $form['first_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('First name'),
      '#required' => TRUE,
      '#attributes' => ['class' => self::INPUT_CLASSES],
    ];
    $form['last_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Last name'),
      '#required' => TRUE,
      '#attributes' => ['class' => self::INPUT_CLASSES],
    ];
    $form['email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#required' => TRUE,
      '#attributes' => [
        'class' => self::INPUT_CLASSES,
        'placeholder' => 'you@media.org',
        'x-bind:placeholder' => "selectedCompany ? ('name@' + selectedCompany.domain) : 'you@media.org'",
        'x-model' => 'emailValue',
      ],
      // Instant client-side hint only — doesn't block typing or submission.
      // The real enforcement stays server-side in validateForm() via
      // CompanyDomainMatcher, unchanged; this just avoids a round trip to
      // discover a mismatch that's already knowable in the browser.
      '#suffix' => Markup::create($this->emailDomainHintMarkup()),
    ];
    $form['pass'] = [
      '#type' => 'password_confirm',
      '#size' => 25,
      '#required' => TRUE,
    ];

    $form['newsletter_opt_in'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('I would like to receive the CFC Media Hub newsletter.'),
      '#wrapper_attributes' => ['class' => ['bg-neutral-50', 'border', 'border-neutral-200', 'rounded-xl', 'px-4', 'py-3.5', 'flex', 'items-center']],
      '#attributes' => ['class' => ['w-4', 'h-4', 'rounded', 'border-neutral-300', 'text-[#9F5434]', 'focus:ring-[#9F5434]', 'mr-3']],
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Create account'),
      '#attributes' => ['class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors']],
    ];

    $form['terms_notice'] = [
      '#markup' => Markup::create($this->termsNoticeMarkup()),
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $type = $form_state->getValue('account_type');
    $email = (string) $form_state->getValue('email');

    if ($type === 'journalist') {
      if (!$form_state->getValue('accreditation_number')) {
        $form_state->setErrorByName('accreditation_number', $this->t('Please enter your press accreditation number.'));
      }
      if (!$form_state->getValue('organization')) {
        $form_state->setErrorByName('organization', $this->t('Please enter your media organisation.'));
      }
      if (!$form_state->getValue('passport_number')) {
        $form_state->setErrorByName('passport_number', $this->t('Please enter your passport number.'));
      }
    }
    else {
      $company_value = $form_state->getValue('cfc_company');
      $company = NULL;
      if (!$company_value) {
        $form_state->setErrorByName('cfc_company', $this->t('Please select your company.'));
      }
      elseif ($company_value !== '_manual') {
        $company = $this->cfcEntityTypeManager->getStorage('taxonomy_term')->load($this->parseCompanyTid($company_value));
      }
      elseif (!$form_state->getValue('manual_organization')) {
        $form_state->setErrorByName('manual_organization', $this->t('Please enter your organisation name.'));
      }

      $error = $this->domainMatcher->validate($email, $company);
      if ($error) {
        $form_state->setErrorByName('email', $error);
      }
    }

    if ($email && user_load_by_mail($email)) {
      $form_state->setErrorByName('email', $this->t('An account already exists for this email address.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $type = $form_state->getValue('account_type');
    $email = (string) $form_state->getValue('email');

    $company_value = $form_state->getValue('cfc_company');
    $organization = $type === 'journalist'
      ? $form_state->getValue('organization')
      : ($company_value === '_manual'
        ? $form_state->getValue('manual_organization')
        : $this->cfcEntityTypeManager->getStorage('taxonomy_term')->load($this->parseCompanyTid($company_value))?->label());

    $values = [
      'name' => $this->generateUsername($email),
      'mail' => $email,
      'pass' => $form_state->getValue('pass'),
      'status' => 1,
      'field_account_type' => $type,
      'field_first_name' => $form_state->getValue('first_name'),
      'field_last_name' => $form_state->getValue('last_name'),
      'field_organization' => $organization,
      'field_newsletter_opt_in' => (bool) $form_state->getValue('newsletter_opt_in'),
      'roles' => [$type === 'journalist' ? 'journalist' : 'cfc_member'],
    ];
    if ($type === 'journalist') {
      $values['field_accreditation_number'] = $form_state->getValue('accreditation_number');
      $values['field_passport_number'] = $form_state->getValue('passport_number');
    }
    elseif ($company_value !== '_manual') {
      $values['field_cfc_company'] = ['target_id' => $this->parseCompanyTid($company_value)];
    }

    $user = $this->cfcEntityTypeManager->getStorage('user')->create($values);
    $user->save();

    user_login_finalize($user);
    $this->messenger()->addStatus($this->t('Welcome to CFC Media Hub, @name.', ['@name' => $form_state->getValue('first_name')]));
    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.account'));
  }

  /**
   * Markup for the "Search for your company…" widget (Alpine-driven),
   * rendered as #prefix right before the real (hidden) cfc_company field so
   * it stays inside the actual <form> in the right position. The company
   * list lives only here (JSON in data-companies) — no <select> anywhere.
   */
  protected function companySearchWidgetMarkup(string $companies_json): string {
    // Nowdoc (no PHP interpolation at all) + str_replace() for the one
    // dynamic value — safer than escaping every literal $ Alpine uses
    // ($refs, $nextTick, $el) inside a real heredoc, which is exactly the
    // kind of subtle mistake that caused two bugs already in this file.
    $markup = <<<'HTML'
      <div class="js-form-wrapper" data-companies='__COMPANIES_JSON__' x-data="{ companies: [] }" x-init="companies = JSON.parse($el.dataset.companies)">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-1.5 font-semibold">Company *</label>

        <template x-if="selectedCompany">
          <div
            class="border border-[#9F5434]/40 rounded-xl px-4 py-3 flex items-center justify-between cursor-pointer bg-[#9F5434]/5 mb-4"
            x-on:click="selectedCompany = null; $nextTick(() => $refs.cfcSearch.focus());"
          >
            <div>
              <div class="text-[14px] text-neutral-900 font-medium" x-text="selectedCompany.name"></div>
              <div class="text-[12px] text-neutral-400" x-text="'@' + selectedCompany.domain"></div>
            </div>
            <span class="text-[12px] text-[#9F5434] underline">Change</span>
          </div>
        </template>

        <template x-if="!selectedCompany">
          <div class="relative mb-4" x-data="{ query: '', open: false }" x-on:click.outside="open = false">
            <div class="relative">
              <span class="icon shrink-0 w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg></span>
              <input
                type="text"
                x-ref="cfcSearch"
                x-model="query"
                x-on:focus="open = true"
                x-on:click="open = true"
                placeholder="Search for your company…"
                autocomplete="off"
                class="w-full border border-neutral-200 rounded-xl pl-10 pr-4 py-3 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#9F5434] transition-colors"
              />
            </div>
            <div x-show="open" x-cloak class="absolute top-full left-0 right-0 mt-1 bg-white border border-neutral-200 rounded-xl shadow-lg z-20 max-h-[220px] overflow-y-auto">
              <template x-for="c in companies.filter((c) => c.name.toLowerCase().includes(query.toLowerCase()))" :key="c.id">
                <button
                  type="button"
                  class="w-full text-left px-4 py-3 hover:bg-[#9F5434]/5 transition-colors border-b border-neutral-100 last:border-0"
                  x-on:click="
                    selectedCompany = c;
                    manualCompany = false;
                    query = '';
                    open = false;
                    $refs.cfcCompanyField.value = c.id + '|' + c.domain;
                    $refs.cfcCompanyField.dispatchEvent(new Event('change', { bubbles: true }));
                  "
                >
                  <div class="text-[14px] text-neutral-900 font-medium" x-text="c.name"></div>
                  <div class="text-[12px] text-neutral-400" x-text="'@' + c.domain"></div>
                </button>
              </template>
              <template x-if="companies.filter((c) => c.name.toLowerCase().includes(query.toLowerCase())).length === 0">
                <div class="px-4 py-3 text-[13px] text-neutral-400">No matching company.</div>
              </template>
            </div>
          </div>
        </template>

        <button
          type="button"
          x-show="!selectedCompany"
          class="text-[12px] text-[#9F5434] underline underline-offset-2 text-left mb-4 block"
          x-on:click="
            manualCompany = true;
            $refs.cfcCompanyField.value = '_manual';
            $refs.cfcCompanyField.dispatchEvent(new Event('change', { bubbles: true }));
          "
        >
          My organisation is not in the list — enter manually
        </button>
      </div>
      HTML;

    // Html::escape() (not Xss::filter() — that's what Markup::create()
    // avoids) guards the one realistic risk here: a company name in the
    // taxonomy containing an apostrophe would otherwise break out of the
    // single-quoted data-companies attribute.
    return str_replace('__COMPANIES_JSON__', Html::escape($companies_json), $markup);
  }

  /**
   * Markup for the CFC Member notice ("Podcast Studio only…"). Visibility
   * comes entirely from the parent #cfc_fields container's x-show — no
   * #states here (see the account_type field's comment on why #states +
   * a dispatched change event on a hidden input is unreliable).
   */
  protected function cfcNoticeMarkup(): string {
    return <<<'HTML'
      <div class="mb-6">
        <div class="bg-[#9F5434]/[0.08] border border-[#9F5434]/25 rounded-xl px-4 py-3.5 flex items-start gap-3">
          <span class="icon shrink-0 w-4 h-4 text-[#9F5434] mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg></span>
          <div class="text-[12px] text-[#9F5434] leading-relaxed font-medium">
            <span class="font-bold">CFC Members have access to the Podcast Studio only.</span><br />
            Meeting Rooms and Desks are not available. Studio access is free of charge.
          </div>
        </div>
      </div>
      HTML;
  }

  /**
   * Markup for the "By creating an account you agree to…" legal notice,
   * shown under the submit button for both account types.
   */
  protected function termsNoticeMarkup(): string {
    return <<<'HTML'
      <div class="text-center text-[12px] text-neutral-400 mt-4">
        By creating an account you agree to our <a href="#" class="text-[#9F5434] underline underline-offset-2 font-semibold">Terms of Service</a> and <a href="#" class="text-[#9F5434] underline underline-offset-2 font-semibold">Privacy Policy</a>.
      </div>
      HTML;
  }

  /**
   * Markup for the inline "email doesn't match selected company" hint.
   * Client-side only, non-blocking — CompanyDomainMatcher (validateForm())
   * remains the real enforcement.
   */
  protected function emailDomainHintMarkup(): string {
    return <<<'HTML'
      <div
        x-show="selectedCompany && emailValue && !emailValue.toLowerCase().endsWith('@' + selectedCompany.domain.toLowerCase())"
        x-cloak
        class="flex items-start gap-2 mt-2 text-[12px] text-red-500"
      >
        <span class="icon shrink-0 w-3.5 h-3.5 mt-0.5"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10" /><line x1="12" x2="12" y1="8" y2="12" /><line x1="12" x2="12.01" y1="16" y2="16" /></svg></span>
        <span>
          The email address must belong to <span x-text="selectedCompany ? selectedCompany.name : ''"></span>'s domain (expected <span x-text="selectedCompany ? '@' + selectedCompany.domain : ''"></span>).
        </span>
      </div>
      HTML;
  }

  /**
   * Extracts the taxonomy term ID from a "tid|domain" cfc_company value.
   */
  protected function parseCompanyTid(?string $value): ?string {
    if (!$value) {
      return NULL;
    }
    return explode('|', $value, 2)[0];
  }

  /**
   * Derives a unique Drupal username from the email's local part.
   */
  protected function generateUsername(string $email): string {
    $base = preg_replace('/[^a-z0-9_.-]/', '', strtolower(strstr($email, '@', TRUE) ?: $email)) ?: 'user';
    $storage = $this->cfcEntityTypeManager->getStorage('user');
    $candidate = $base;
    $suffix = 1;
    while ($storage->loadByProperties(['name' => $candidate])) {
      $candidate = $base . $suffix++;
    }
    return $candidate;
  }

}
