<?php

namespace Drupal\cfc_connections\Form;

use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Html;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\ReplaceCommand;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * The "Submit a Connection Request" modal form (CFCA / CFC Member / other).
 *
 * One form, three "who do you want to connect with" branches toggled purely
 * via Alpine's "selected" state (x-show) — not Drupal's #states, which
 * doesn't reliably react to a JS-dispatched change event on a hidden field.
 * AJAX is scoped to the inner "dynamic" container only, so the type-selector
 * cards (and any in-progress company search) never lose their Alpine state
 * across a validation-error round trip.
 *
 * Submissions are stored as a Webform submission (webform "connection_request")
 * rather than a plain entity, so the CFC team can review/export them and
 * manage the notification email from the normal Webform UI — this form's own
 * markup is the only Figma-matched part; Webform is never rendered to
 * visitors, it's used purely as the backoffice + email backend.
 */
class ConnectionRequestForm extends FormBase {

  protected const INPUT_CLASSES = ['w-full', 'border', 'border-neutral-200', 'rounded-xl', 'px-4', 'py-3', 'text-[14px]', 'text-neutral-900', 'bg-white', 'focus:outline-none', 'focus:border-[#9F5434]/50', 'transition-colors'];

  protected const TYPE_LABELS = [
    'cfca' => 'CFCA',
    'member' => 'A CFC Member',
    'other' => 'Another organisation',
  ];

  public function __construct(
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static($container->get('entity_type.manager'));
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_connection_request_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#attributes']['class'][] = 'px-8';
    $form['#attributes']['class'][] = 'py-6';
    // Shared with the submit button below so it can grey itself out until a
    // type is picked, matching the prototype's disabled-looking initial state.
    $form['#attributes']['x-data'] = "{ selected: '' }";

    // Persistent across AJAX round trips (lives outside the "dynamic"
    // wrapper below) — the hidden field the cards write into via Alpine.
    $form['connection_type'] = [
      '#type' => 'hidden',
      '#attributes' => ['x-ref' => 'connectionTypeField'],
      '#prefix' => Markup::create($this->typeCardsMarkup()),
    ];

    // Everything whose visibility/content depends on connection_type is
    // re-rendered by AJAX (validation errors, then the success message) —
    // scoped here so the cards above are never touched.
    $form['dynamic'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'connection-request-dynamic'],
    ];

    $companies = $this->cfcEntityTypeManager->getStorage('taxonomy_term')->loadTree('cfc_member_companies', 0, 1, TRUE);
    $company_data = array_map(static fn($term) => [
      'id' => (string) $term->id(),
      'name' => $term->label(),
      'domain' => (string) $term->get('field_company_domain')->value,
    ], $companies);
    $form['dynamic']['target_member'] = [
      '#type' => 'hidden',
      '#attributes' => ['x-ref' => 'targetMemberField'],
      '#prefix' => Markup::create($this->memberSearchWidgetMarkup(Json::encode($company_data))),
    ];

    // Visibility below is driven entirely by Alpine's "selected" state (not
    // Drupal's #states): the hidden connection_type field only needs to
    // carry the value for validation/submission, since Alpine already
    // proved reliable for the cards themselves and this avoids relying on
    // core/drupal.states picking up a JS-dispatched change event.
    $form['dynamic']['organisation_name'] = [
      '#type' => 'textfield',
      '#title' => Markup::create('Organisation name <span class="text-red-500">*</span>'),
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'Enter the organisation you wish to contact'],
      '#wrapper_attributes' => ['x-show' => "selected === 'other'", 'x-cloak' => TRUE],
    ];

    $form['dynamic']['fields_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['x-show' => "selected !== ''", 'x-cloak' => TRUE],
    ];

    $form['dynamic']['fields_wrapper']['purpose'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Purpose of request'),
      '#required' => TRUE,
      '#rows' => 3,
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'Describe the context and purpose of your connection request…'],
    ];

    $form['dynamic']['fields_wrapper']['names'] = ['#type' => 'container', '#attributes' => ['class' => ['grid', 'grid-cols-2', 'gap-4']]];
    $form['dynamic']['fields_wrapper']['names']['contact_name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Your name'),
      '#required' => TRUE,
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'Full name'],
    ];
    $form['dynamic']['fields_wrapper']['names']['contact_email'] = [
      '#type' => 'email',
      '#title' => $this->t('Email address'),
      '#required' => TRUE,
      '#attributes' => ['class' => self::INPUT_CLASSES, 'placeholder' => 'you@media.org'],
    ];

    // Outside fields_wrapper — the submit button stays visible (just greyed
    // out via its own x-bind:disabled) even before a type is picked, matching
    // the prototype's initial state.
    $form['dynamic']['actions'] = ['#type' => 'actions'];
    $form['dynamic']['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit request'),
      '#attributes' => [
        'class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'text-white', 'py-3.5', 'rounded-xl', 'text-[14px]', 'font-semibold', 'transition-colors'],
        'x-bind:disabled' => '!selected',
        'x-bind:class' => "selected ? '' : 'opacity-50 cursor-not-allowed'",
      ],
      '#ajax' => [
        'callback' => '::ajaxSubmit',
        'wrapper' => 'connection-request-dynamic',
      ],
    ];
    $form['dynamic']['footer_note'] = [
      '#markup' => '<p class="text-center text-[12px] text-neutral-400 mt-4">' . $this->t('Our team will get back to you shortly.') . '</p>',
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $type = $form_state->getValue('connection_type');

    if (!$type || !isset(self::TYPE_LABELS[$type])) {
      $form_state->setErrorByName('connection_type', $this->t('Please choose who you would like to connect with.'));
      return;
    }

    if ($type === 'member' && !$form_state->getValue('target_member')) {
      $form_state->setErrorByName('target_member', $this->t('Please select a CFC member company.'));
    }
    if ($type === 'other' && !trim((string) $form_state->getValue('organisation_name'))) {
      $form_state->setErrorByName('organisation_name', $this->t('Please enter the organisation you wish to contact.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $type = $form_state->getValue('connection_type');
    $tid = NULL;

    if ($type === 'member') {
      $tid = (int) $form_state->getValue('target_member');
      $term = $this->cfcEntityTypeManager->getStorage('taxonomy_term')->load($tid);
      $organisation = $term?->label() ?? (string) $this->t('Unknown member');
    }
    elseif ($type === 'other') {
      $organisation = $form_state->getValue('organisation_name');
    }
    else {
      $organisation = 'Casablanca Finance City Authority (CFCA)';
    }

    // Stored as a Webform submission (not a plain entity) so the CFC team
    // can review, export and manage the notification email from the normal
    // Webform admin UI — the "connection_request" webform is never rendered
    // to visitors, only used as this form's backoffice + email backend.
    $data = [
      'connection_type' => $type,
      'organisation_name' => $organisation,
      'purpose' => $form_state->getValue('purpose'),
      'contact_name' => $form_state->getValue('contact_name'),
      'contact_email' => $form_state->getValue('contact_email'),
    ];
    if ($tid) {
      $data['target_member'] = $tid;
    }

    WebformSubmission::create([
      'webform_id' => 'connection_request',
      'data' => $data,
    ])->save();
  }

  /**
   * AJAX callback — re-renders the "dynamic" wrapper: validation errors in
   * place, or the success message once the request has been saved.
   */
  public function ajaxSubmit(array &$form, FormStateInterface $form_state): AjaxResponse {
    $response = new AjaxResponse();

    if ($form_state->getErrors()) {
      $response->addCommand(new ReplaceCommand('#connection-request-dynamic', $form['dynamic']));
      return $response;
    }

    $success = [
      '#type' => 'container',
      '#attributes' => ['id' => 'connection-request-dynamic'],
      'content' => ['#markup' => Markup::create($this->successMarkup())],
    ];
    $response->addCommand(new ReplaceCommand('#connection-request-dynamic', $success));
    return $response;
  }

  /**
   * Markup for the three "who would you like to connect with" cards
   * (Alpine-driven, same click-sets-hidden-field-and-dispatches-change
   * convention as AccountRegisterForm's company widget).
   */
  protected function typeCardsMarkup(): string {
    $markup = <<<'HTML'
      <div class="mb-6">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-2.5 font-semibold">Who would you like to connect with? *</label>
        <div class="grid grid-cols-3 gap-3">
          <div
            class="border rounded-xl px-4 py-3.5 cursor-pointer transition-colors"
            x-bind:class="selected === 'cfca' ? 'border-[#9F5434] bg-[#9F5434]/5' : 'border-neutral-200 hover:border-neutral-300'"
            x-on:click="selected = 'cfca'; $refs.connectionTypeField.value = 'cfca'; $refs.connectionTypeField.dispatchEvent(new Event('change', { bubbles: true }));"
          >
            <div class="text-[14px] font-semibold text-neutral-900">CFCA</div>
            <div class="text-[11px] text-neutral-400 mt-0.5">Casablanca Finance City Authority</div>
            <div x-show="selected === 'cfca'" x-cloak class="w-4 h-[2px] bg-[#9F5434] mt-2"></div>
          </div>
          <div
            class="border rounded-xl px-4 py-3.5 cursor-pointer transition-colors"
            x-bind:class="selected === 'member' ? 'border-[#9F5434] bg-[#9F5434]/5' : 'border-neutral-200 hover:border-neutral-300'"
            x-on:click="selected = 'member'; $refs.connectionTypeField.value = 'member'; $refs.connectionTypeField.dispatchEvent(new Event('change', { bubbles: true }));"
          >
            <div class="text-[14px] font-semibold text-neutral-900">A CFC Member</div>
            <div class="text-[11px] text-neutral-400 mt-0.5">Company from the CFC community</div>
            <div x-show="selected === 'member'" x-cloak class="w-4 h-[2px] bg-[#9F5434] mt-2"></div>
          </div>
          <div
            class="border rounded-xl px-4 py-3.5 cursor-pointer transition-colors"
            x-bind:class="selected === 'other' ? 'border-[#9F5434] bg-[#9F5434]/5' : 'border-neutral-200 hover:border-neutral-300'"
            x-on:click="selected = 'other'; $refs.connectionTypeField.value = 'other'; $refs.connectionTypeField.dispatchEvent(new Event('change', { bubbles: true }));"
          >
            <div class="text-[14px] font-semibold text-neutral-900">Another organisation</div>
            <div class="text-[11px] text-neutral-400 mt-0.5">Any other entity</div>
            <div x-show="selected === 'other'" x-cloak class="w-4 h-[2px] bg-[#9F5434] mt-2"></div>
          </div>
        </div>
      </div>
      HTML;

    return $markup;
  }

  /**
   * Markup for the "Search for a company…" widget — same pattern as
   * AccountRegisterForm's company search, minus the domain-matching parts
   * that form doesn't need here (no "enter manually" fallback either: the
   * design only offers a search + list for the CFC Member branch).
   */
  protected function memberSearchWidgetMarkup(string $companies_json): string {
    $markup = <<<'HTML'
      <div class="mb-5" x-show="selected === 'member'" x-cloak data-companies='__COMPANIES_JSON__' x-data="{ companies: JSON.parse($el.dataset.companies), selectedCompany: null, query: '', open: false }" x-on:click.outside="open = false">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-1.5 font-semibold">Select a CFC Member *</label>

        <template x-if="selectedCompany">
          <div
            class="border border-[#9F5434]/40 rounded-xl px-4 py-3 flex items-center justify-between cursor-pointer bg-[#9F5434]/5"
            x-on:click="selectedCompany = null; $refs.targetMemberField.value = ''; $refs.targetMemberField.dispatchEvent(new Event('change', { bubbles: true })); $nextTick(() => $refs.memberSearch.focus());"
          >
            <div class="text-[14px] text-neutral-900 font-medium" x-text="selectedCompany.name"></div>
            <span class="text-[12px] text-[#9F5434] underline">Change</span>
          </div>
        </template>

        <template x-if="!selectedCompany">
          <div class="relative">
            <div class="relative">
              <span class="icon shrink-0 w-4 h-4 absolute left-4 top-1/2 -translate-y-1/2 text-neutral-400"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8" /><path d="m21 21-4.3-4.3" /></svg></span>
              <input
                type="text"
                x-ref="memberSearch"
                x-model="query"
                x-on:focus="open = true"
                x-on:click="open = true"
                placeholder="Search for a company…"
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
                    query = '';
                    open = false;
                    $refs.targetMemberField.value = c.id;
                    $refs.targetMemberField.dispatchEvent(new Event('change', { bubbles: true }));
                  "
                >
                  <div class="text-[14px] text-neutral-900 font-medium" x-text="c.name"></div>
                </button>
              </template>
              <template x-if="companies.filter((c) => c.name.toLowerCase().includes(query.toLowerCase())).length === 0">
                <div class="px-4 py-3 text-[13px] text-neutral-400">No matching company.</div>
              </template>
            </div>
          </div>
        </template>
      </div>
      HTML;

    return str_replace('__COMPANIES_JSON__', Html::escape($companies_json), $markup);
  }

  /**
   * Markup for the post-submit success state.
   */
  protected function successMarkup(): string {
    return <<<'HTML'
      <div class="px-0 py-6 text-center">
        <div class="w-12 h-12 rounded-full bg-[#E1F5EE] text-[#0F6E56] flex items-center justify-center mx-auto mb-4">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6"><path d="M20 6 9 17l-5-5" /></svg>
        </div>
        <div class="text-neutral-900 font-semibold text-[16px] mb-2">Request submitted.</div>
        <p class="text-neutral-500 text-[14px]">Our team will get back to you shortly to coordinate the introduction.</p>
      </div>
      HTML;
  }

}
