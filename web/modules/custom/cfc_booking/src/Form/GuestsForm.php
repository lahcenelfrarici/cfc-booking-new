<?php

namespace Drupal\cfc_booking\Form;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Add/remove guests for an already-created booking, from the Review page.
 *
 * Embedded directly in ReviewController (same pattern as PaymentForm in
 * BookingController/PaymentController) — no dedicated route. The dynamic
 * "+ Add guest" rows are entirely client-side (Alpine); the only real field
 * is a single hidden guests_json, kept in sync via $watch and parsed here
 * on submit — same "one hidden field + JSON" pattern as the booking
 * datetime picker and the CFC company search widget.
 */
class GuestsForm extends FormBase {

  public function __construct(
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
    protected AccountProxyInterface $currentUser,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('entity_type.manager'),
      $container->get('current_user'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_booking_guests_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?NodeInterface $node = NULL): array {
    if (!$this->isEditable($node)) {
      return $form;
    }

    $form_state->set('cfc_booking_nid', (int) $node->id());

    $space = $node->get('field_space')->entity;
    $max_guests = $space ? (int) $space->get('field_max_guests')->value : 0;

    $current_guests = array_map(
      static fn(string $full_name) => self::splitName($full_name),
      array_map(static fn($item) => $item->value, iterator_to_array($node->get('field_guest_names')))
    );

    $form['guests_json'] = [
      '#type' => 'hidden',
      '#attributes' => ['id' => 'cfc-guests-json'],
      '#default_value' => Json::encode($current_guests),
    ];

    $form['widget'] = [
      '#markup' => Markup::create($this->guestsWidgetMarkup($max_guests)),
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save guests'),
      '#attributes' => ['class' => ['text-[13px]', 'text-[#9F5434]', 'font-semibold', 'hover:text-[#8A4A2E]', 'transition-colors']],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $node = $this->loadNode($form_state);
    if (!$this->isEditable($node)) {
      $form_state->setErrorByName('guests_json', $this->t('This reservation can no longer be edited.'));
      return;
    }

    $space = $node->get('field_space')->entity;
    $max_guests = $space ? (int) $space->get('field_max_guests')->value : 0;

    $guests = json_decode((string) $form_state->getValue('guests_json'), TRUE) ?: [];
    if (count($guests) > $max_guests) {
      $form_state->setErrorByName('guests_json', $this->t('This space allows a maximum of @max guest(s).', ['@max' => $max_guests]));
      return;
    }
    foreach ($guests as $guest) {
      if (empty($guest['first_name']) || empty($guest['last_name'])) {
        $form_state->setErrorByName('guests_json', $this->t('Please complete all guest name fields.'));
        return;
      }
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $node = $this->loadNode($form_state);
    $guests = json_decode((string) $form_state->getValue('guests_json'), TRUE) ?: [];

    $names = array_map(
      static fn(array $guest) => trim($guest['first_name']) . ' ' . trim($guest['last_name']),
      $guests
    );
    $node->set('field_guest_names', $names);
    $node->save();

    $this->messenger()->addStatus($this->t('Guests updated.'));
    $form_state->setRedirectUrl(Url::fromRoute('cfc_booking.review', ['node' => $node->id()]));
  }

  /**
   * Loads the booking node this form was built for.
   */
  protected function loadNode(FormStateInterface $form_state): ?NodeInterface {
    $nid = $form_state->get('cfc_booking_nid');
    return $nid ? $this->cfcEntityTypeManager->getStorage('node')->load($nid) : NULL;
  }

  /**
   * A booking's guests can be edited by its owner while still upcoming.
   */
  protected function isEditable(?NodeInterface $node): bool {
    return $node
      && $node->bundle() === 'booking'
      && (int) $node->getOwnerId() === (int) $this->currentUser->id()
      && $node->get('field_status')->value === 'upcoming';
  }

  /**
   * Splits a stored "First Last" guest name back into parts for the form.
   */
  protected static function splitName(string $full_name): array {
    $parts = explode(' ', trim($full_name), 2);
    return ['first_name' => $parts[0] ?? '', 'last_name' => $parts[1] ?? ''];
  }

  /**
   * Markup for the dynamic guest list (Alpine-driven), always wrapped in
   * Markup::create() at the call site — see AccountRegisterForm for why
   * (Xss::filter() mangles Alpine's `x-data="{ ... }"` syntax otherwise).
   */
  protected function guestsWidgetMarkup(int $max_guests): string {
    $markup = <<<'HTML'
      <div
        class="js-form-wrapper"
        x-data="{ guests: JSON.parse(document.getElementById('cfc-guests-json').value || '[]') }"
        x-init="$watch('guests', (v) => { document.getElementById('cfc-guests-json').value = JSON.stringify(v); })"
      >
        <div class="flex items-center justify-between mb-4">
          <div class="text-[12px] uppercase tracking-wide text-[#9F5434] font-semibold">
            Guests <span class="text-[10px] text-neutral-400 normal-case ml-1">(max __MAX_GUESTS__)</span>
          </div>
          <button
            type="button"
            x-show="guests.length < __MAX_GUESTS__"
            x-on:click="guests.push({ first_name: '', last_name: '' })"
            class="text-[12px] text-[#9F5434] hover:text-[#8A4A2E] flex items-center gap-1 transition-colors font-semibold"
          >
            + Add guest
          </button>
        </div>

        <template x-if="guests.length === 0">
          <div class="text-[13px] text-neutral-400">No guests added. Click "Add guest" to invite someone.</div>
        </template>

        <template x-for="(guest, index) in guests" :key="index">
          <div class="mb-5">
            <div class="flex items-center justify-between mb-3">
              <span class="text-[12px] text-[#9F5434] uppercase tracking-wide font-semibold" x-text="'Guest ' + (index + 1)"></span>
              <button type="button" x-on:click="guests.splice(index, 1)" class="text-[12px] text-neutral-400 hover:text-red-500 transition-colors">
                Remove
              </button>
            </div>
            <div class="grid grid-cols-2 gap-4">
              <input type="text" x-model="guest.first_name" placeholder="First name" class="w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#9F5434] transition-colors" />
              <input type="text" x-model="guest.last_name" placeholder="Last name" class="w-full border border-neutral-200 rounded-xl px-4 py-3 text-[14px] text-neutral-900 bg-white focus:outline-none focus:border-[#9F5434] transition-colors" />
            </div>
          </div>
        </template>
      </div>
      HTML;

    return str_replace('__MAX_GUESTS__', (string) $max_guests, $markup);
  }

}
