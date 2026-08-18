<?php

namespace Drupal\cfc_booking\Form;

use Drupal\cfc_booking\AvailabilityChecker;
use Drupal\cfc_content\ContentRepository;
use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Html;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Render\Markup;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Single-page booking form: space, date, time, duration, guests.
 *
 * No multistep wizard, no separate availability API — the space list is
 * filtered by the user's role server-side, and availability is re-checked
 * in validateForm() under a short-lived lock. See the account/booking MVP
 * plan for the reasoning.
 */
class BookingForm extends FormBase {

  protected const INPUT_CLASSES = ['w-full', 'border', 'border-neutral-200', 'rounded-xl', 'px-4', 'py-3', 'text-[14px]', 'text-neutral-900', 'bg-white', 'focus:outline-none', 'focus:border-[#0F6E56]'];

  protected const TIME_SLOTS = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00'];

  public function __construct(
    protected ContentRepository $contentRepository,
    protected AvailabilityChecker $availabilityChecker,
    protected AccountProxyInterface $currentUser,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cfc_content.repository'),
      $container->get('cfc_booking.availability_checker'),
      $container->get('current_user'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_booking_form';
  }

  /**
   * Returns the Space data eligible for the current user's role.
   */
  protected function eligibleSpaces(): array {
    $roles = $this->currentUser->getRoles();
    $allowed_rules = [];
    if (in_array('journalist', $roles, TRUE)) {
      $allowed_rules = array_merge($allowed_rules, ['journalist', 'both']);
    }
    if (in_array('cfc_member', $roles, TRUE)) {
      $allowed_rules = array_merge($allowed_rules, ['company', 'both']);
    }
    $filtered = array_filter(
      $this->contentRepository->getSpaces(),
      static fn(array $space) => in_array($space['access_rule'], $allowed_rules, TRUE)
    );
    // Re-key by machine key ("desk"/"meeting"/"studio") so $spaces[$id]
    // lookups work — getSpaces() returns a plain sequential list.
    return array_column($filtered, NULL, 'id');
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state, ?string $initial_space = NULL): array {
    $form['#attributes']['class'][] = 'space-y-5';
    $spaces = $this->eligibleSpaces();

    if (!$spaces) {
      $form['empty'] = [
        '#markup' => '<p class="text-neutral-500 text-[14px]">No spaces are currently available for your account type.</p>',
      ];
      return $form;
    }

    $space_options = array_combine(array_column($spaces, 'id'), array_column($spaces, 'title'));
    $selected_space_id = $form_state->getValue('space') ?: (($initial_space && isset($space_options[$initial_space])) ? $initial_space : NULL);

    $form['space'] = [
      '#type' => 'select',
      '#title' => $this->t('Space'),
      '#options' => $space_options,
      '#default_value' => $selected_space_id,
      '#empty_option' => $this->t('— Select a space —'),
      '#required' => TRUE,
      '#attributes' => ['class' => self::INPUT_CLASSES],
      '#ajax' => [
        'callback' => '::updateDatetimeAjax',
        'wrapper' => 'cfc-datetime-wrapper',
        'event' => 'change',
      ],
      // The visible picker is a card grid (#prefix) instead of the raw
      // <select> (hidden via CSS, see components.css) — clicking a card
      // sets the select's value + dispatches change, which both the #ajax
      // above and (if anything else ever depends on it) #states pick up
      // normally, same pattern as account_type/cfc_company elsewhere.
      '#prefix' => Markup::create($this->spaceCardsMarkup($spaces, $selected_space_id)),
    ];

    $form['datetime_wrapper'] = $this->buildDatetimeWrapper($spaces[$selected_space_id] ?? NULL);

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Make a reservation'),
      '#attributes' => ['class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors']],
    ];

    return $form;
  }

  /**
   * Markup for the space picker: a card per eligible space (title,
   * description, capacity, price), matching the prototype's SpaceSelect.
   * Clicking a card writes into the real (CSS-hidden) 'space' select and
   * dispatches change — same pattern as the "Who are you?" account type
   * cards. Always wrapped in Markup::create() at the call site: Xss::filter()
   * mangles Alpine's `x-data="{ ... }"` syntax otherwise (learned earlier
   * in this project, twice).
   */
  protected function spaceCardsMarkup(array $spaces, ?string $selected): string {
    $cards = '';
    foreach ($spaces as $space) {
      $id = Html::escape($space['id']);
      $title = Html::escape($space['title']);
      $subtitle = Html::escape($space['subtitle']);
      $summary = Html::escape($space['summary']);
      $meta = Html::escape($space['capacity_meta']);
      $price = Html::escape($space['price_label']);

      if (!empty($space['highlight'])) {
        $unselected_classes = 'bg-[#0F6E56] border-[#0F6E56] text-white';
        $selected_classes = 'bg-[#0F6E56] border-white ring-4 ring-[#0F6E56] text-white -translate-y-1 shadow-[0_20px_50px_-20px_rgba(15,110,86,0.5)]';
        $eyebrow_class = 'text-white/60';
        $desc_class = 'text-white/80';
        $meta_class = 'text-white/70';
        $price_class = 'text-[#CDEDE3]';
        $badge_class = 'bg-white text-[#0F6E56]';
      }
      else {
        $unselected_classes = 'bg-white border-neutral-200 hover:border-neutral-400';
        $selected_classes = 'bg-[#9F5434]/[0.06] border-[#9F5434] -translate-y-1 shadow-[0_20px_50px_-20px_rgba(159,84,52,0.35)]';
        $eyebrow_class = 'text-neutral-400';
        $desc_class = 'text-neutral-500';
        $meta_class = 'text-neutral-400';
        $price_class = 'text-[#0F6E56]';
        $badge_class = 'bg-[#9F5434] text-white';
      }

      $cards .= <<<HTML
        <button
          type="button"
          x-on:click="
            selectedSpace = '{$id}';
            jQuery('#edit-space').val('{$id}').trigger('change');
          "
          x-bind:class="selectedSpace === '{$id}' ? '{$selected_classes} border-2' : '{$unselected_classes} border'"
          class="relative text-left rounded-2xl p-7 transition-all duration-150"
        >
          <div
            x-show="selectedSpace === '{$id}'"
            x-cloak
            class="absolute top-4 right-4 w-6 h-6 rounded-full flex items-center justify-center {$badge_class}"
          >
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round" class="w-3.5 h-3.5"><path d="M20 6 9 17l-5-5" /></svg>
          </div>
          <div class="text-[11px] uppercase tracking-[0.16em] mb-2 font-semibold {$eyebrow_class}">{$subtitle}</div>
          <h3 class="tracking-tight mb-3" style="font-size: 24px; font-weight: 600; letter-spacing: -0.02em;">{$title}</h3>
          <p class="leading-relaxed mb-6 text-[13px] {$desc_class}">{$summary}</p>
          <div class="text-[12px] mb-1 {$meta_class}">{$meta}</div>
          <div class="text-[13px] font-semibold {$price_class}">{$price}</div>
        </button>
        HTML;
    }

    $selected_js = Html::escape((string) $selected);
    return <<<HTML
      <div class="mb-6">
        <label class="text-[12px] text-neutral-600 uppercase tracking-wide block mb-3 font-semibold">Space *</label>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4" x-data="{ selectedSpace: '{$selected_js}' }">
          {$cards}
        </div>
      </div>
      HTML;
  }

  /**
   * Builds the container holding the hidden date/time/duration fields and
   * the visual calendar/time-slot/duration picker component. Rebuilt
   * whenever the selected space changes (via #ajax on the 'space' select).
   */
  protected function buildDatetimeWrapper(?array $space_data): array {
    $wrapper = [
      '#type' => 'container',
      '#attributes' => ['id' => 'cfc-datetime-wrapper'],
    ];

    $durations = $space_data['slot_durations'] ?? array_keys(AvailabilityChecker::DURATION_HOURS);
    $default_duration = $durations[0] ?? '1 hour';

    $wrapper['booking_date'] = [
      '#type' => 'hidden',
      '#required' => TRUE,
      '#attributes' => ['id' => 'cfc-booking-date'],
    ];
    $wrapper['time_slot'] = [
      '#type' => 'hidden',
      '#required' => TRUE,
      '#attributes' => ['id' => 'cfc-booking-time'],
    ];
    $wrapper['duration'] = [
      '#type' => 'hidden',
      '#required' => TRUE,
      '#default_value' => $default_duration,
      '#attributes' => ['id' => 'cfc-booking-duration'],
    ];

    $days = $this->next14Days();
    $matrix = [];
    if ($space_data) {
      $space_node = $this->cfcEntityTypeManager->getStorage('node')->load($space_data['nid']);
      $matrix = $this->availabilityChecker->buildMatrix($space_node, array_column($days, 'iso'), self::TIME_SLOTS, $durations);
    }

    $wrapper['picker'] = [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:booking-datetime-picker',
      '#props' => [
        'has_space' => (bool) $space_data,
        'days' => $days,
        'time_slots' => self::TIME_SLOTS,
        'durations' => $durations,
        'durations_json' => Json::encode($durations),
        'matrix' => Json::encode($matrix),
        'default_duration' => $default_duration,
        'date_field_id' => 'cfc-booking-date',
        'time_field_id' => 'cfc-booking-time',
        'duration_field_id' => 'cfc-booking-duration',
      ],
    ];

    return $wrapper;
  }

  /**
   * Returns the next 14 days as [iso, weekday, day, month] for the calendar.
   */
  protected function next14Days(): array {
    $days = [];
    $today = new \DateTime('today');
    for ($i = 0; $i < 14; $i++) {
      $date = (clone $today)->modify("+$i days");
      $days[] = [
        'iso' => $date->format('Y-m-d'),
        'weekday' => $date->format('D'),
        'day' => $date->format('j'),
        'month' => $date->format('M'),
      ];
    }
    return $days;
  }

  /**
   * #ajax callback for the 'space' select: returns the rebuilt datetime
   * wrapper (calendar/time-grid/duration) for the newly selected space.
   */
  public function updateDatetimeAjax(array &$form, FormStateInterface $form_state): array {
    return $form['datetime_wrapper'];
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    $spaces = $this->eligibleSpaces();
    $space_id = $form_state->getValue('space');
    $space_data = $spaces[$space_id] ?? NULL;

    if (!$space_data) {
      $form_state->setErrorByName('space', $this->t('Please select a valid space for your account type.'));
      return;
    }

    $duration = $form_state->getValue('duration');
    if (!in_array($duration, $space_data['slot_durations'], TRUE)) {
      $form_state->setErrorByName('duration', $this->t('"@duration" is not available for @space. Available durations: @list', [
        '@duration' => $duration,
        '@space' => $space_data['title'],
        '@list' => implode(', ', $space_data['slot_durations']),
      ]));
      return;
    }

    $date = $form_state->getValue('booking_date');
    $time_slot = $form_state->getValue('time_slot');

    // Re-check availability under a short-lived lock so two near-simultaneous
    // submissions for the same slot can't both pass.
    $lock_name = 'cfc_booking:' . $space_id . ':' . $date;
    $lock = \Drupal::lock();
    if (!$lock->acquire($lock_name, 5)) {
      $form_state->setErrorByName('time_slot', $this->t('This slot is being booked by someone else right now — please try again in a moment.'));
      return;
    }
    $form_state->set('cfc_lock_name', $lock_name);

    $space_node = $this->cfcEntityTypeManager->getStorage('node')->load($space_data['nid']);
    if (!$this->availabilityChecker->isFree($space_node, $date, $time_slot, $duration)) {
      $lock->release($lock_name);
      $form_state->setErrorByName('time_slot', $this->t('This slot is no longer available for @space. Please choose another time.', ['@space' => $space_data['title']]));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $spaces = $this->eligibleSpaces();
    $space_id = $form_state->getValue('space');
    $space_data = $spaces[$space_id];
    $is_paid = $space_data['hourly_rate'] > 0;

    $reference = 'RES-' . date('Y') . '-' . random_int(1000, 9999);
    $duration = $form_state->getValue('duration');
    $amount = $is_paid ? $space_data['hourly_rate'] * AvailabilityChecker::DURATION_HOURS[$duration] : NULL;

    $booking = $this->cfcEntityTypeManager->getStorage('node')->create([
      'type' => 'booking',
      'title' => $space_data['title'] . ' — ' . $form_state->getValue('booking_date') . ' ' . $form_state->getValue('time_slot'),
      'uid' => $this->currentUser->id(),
      'field_space' => ['target_id' => $space_data['nid']],
      'field_booking_date' => $form_state->getValue('booking_date'),
      'field_time_slot' => $form_state->getValue('time_slot'),
      'field_duration' => $duration,
      'field_guest_names' => [],
      'field_status' => 'upcoming',
      'field_reference' => $reference,
      'field_price' => $space_data['price_label'],
      'field_amount' => $amount,
      'field_currency' => $is_paid ? $space_data['currency'] : NULL,
      'field_payment_status' => $is_paid ? 'pending' : 'not_applicable',
      'status' => 1,
    ]);
    $booking->save();

    if ($lock_name = $form_state->get('cfc_lock_name')) {
      \Drupal::lock()->release($lock_name);
    }

    $this->messenger()->addStatus($this->t('Reservation @ref created — please review the details below.', ['@ref' => $reference]));
    $form_state->setRedirectUrl(Url::fromRoute('cfc_booking.review', ['node' => $booking->id()]));
  }

}
