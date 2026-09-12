<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\cfc_booking\AvailabilityChecker;
use Drupal\cfc_booking\BookingCreator;
use Drupal\cfc_content\ContentRepository;
use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the CFC Media Hub homepage from the marketing section components.
 */
class HomeController extends ControllerBase {

  public function __construct(
    protected ContentRepository $contentRepository,
    protected AvailabilityChecker $availabilityChecker,
    protected BookingCreator $bookingCreator,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cfc_content.repository'),
      $container->get('cfc_booking.availability_checker'),
      $container->get('cfc_booking.creator'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Builds the homepage render array.
   */
  public function build(): array {
    $spaces_url = Url::fromRoute('cfc_pages.spaces')->toString();
    $production_url = Url::fromRoute('cfc_pages.production')->toString();
    $booking_base_url = Url::fromRoute('cfc_pages.booking')->toString();
    $next_slots = $this->buildNextSlots();
    $space_pickers = $this->buildSpacePickers();

    return [
      'hero' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:hero',
        '#props' => [
          'spaces_url' => $spaces_url,
          'production_url' => $production_url,
          'booking_base_url' => $booking_base_url,
          'next_slots' => $next_slots,
          'next_slots_json' => Json::encode($next_slots),
          'space_pickers_json' => Json::encode($space_pickers),
          'duration_hours_json' => Json::encode(AvailabilityChecker::DURATION_HOURS),
          'time_slots_json' => Json::encode(AvailabilityChecker::TIME_SLOTS),
          'eligible_json' => Json::encode($this->eligibleSpaceIds()),
          'quick_book_template' => Url::fromRoute('cfc_booking.quick_book', [
            'space' => '__SPACE__',
            'date' => '__DATE__',
            'time' => '__TIME__',
            'duration' => '__DURATION__',
          ])->toString(),
        ],
        '#cache' => [
          'contexts' => ['user.roles', 'user'],
          'tags' => ['node_list:booking', 'node_list:space'],
          'max-age' => 300,
        ],
      ],
      'spaces' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:spaces-teaser',
        '#props' => [
          'spaces_url' => $spaces_url,
          'booking_base_url' => $booking_base_url,
          'spaces' => $this->contentRepository->getSpaces(),
        ],
        '#cache' => ['tags' => ['node_list:space']],
      ],
      'productions' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:productions-section',
        '#props' => [
          'production_url' => $production_url,
          'productions' => $this->contentRepository->getProductions(5),
        ],
        '#cache' => ['tags' => ['node_list:production']],
      ],
      'ecosystem' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:ecosystem-cta',
      ],
      'final_cta' => [
        '#type' => 'component',
        '#component' => 'cfc_media_hub:final-cta',
        '#props' => [
          'booking_base_url' => $booking_base_url,
          'slots' => $next_slots,
        ],
        '#cache' => [
          'contexts' => ['user.roles', 'user'],
          'tags' => ['node_list:booking', 'node_list:space'],
          'max-age' => 300,
        ],
      ],
    ];
  }

  /**
   * Builds the real "next available slot" data for Desk/Meeting Room/Studio,
   * shared by the final-cta and booking-widget components. For a slot to
   * link straight into a direct booking (cfc_booking.quick_book) the
   * current user must be authenticated *and* eligible for that space —
   * otherwise it falls back to the manual /booking?space=X flow, which
   * already handles both of those cases correctly on its own.
   *
   * @return array
   *   Keyed by space id ("desk"/"meeting"/"studio"), each entry:
   *   id, title, day_label, time_range, book_url.
   */
  protected function buildNextSlots(): array {
    $eligible = $this->currentUser()->isAuthenticated()
      ? $this->bookingCreator->eligibleSpaces($this->currentUser()->getRoles())
      : [];

    $slots = [];
    foreach ($this->contentRepository->getSpaces() as $space_data) {
      $duration = $space_data['slot_durations'][0] ?? '2 hours';
      $space_node = $this->cfcEntityTypeManager->getStorage('node')->load($space_data['nid']);
      $next = $space_node ? $this->availabilityChecker->findNextAvailable($space_node, $duration) : NULL;

      if (!$next) {
        // Nothing free in the lookout window — omit rather than show a dead slot.
        continue;
      }

      $book_url = isset($eligible[$space_data['id']])
        ? Url::fromRoute('cfc_booking.quick_book', [
          'space' => $space_data['id'],
          'date' => $next['date'],
          'time' => $next['time'],
          'duration' => $duration,
        ])->toString()
        : Url::fromRoute('cfc_pages.booking', [], ['query' => ['space' => $space_data['id']]])->toString();

      $slots[$space_data['id']] = [
        'id' => $space_data['id'],
        'title' => $space_data['title'],
        'day_label' => $this->dayLabel($next['date']),
        'time_range' => $next['time'] . ' – ' . $this->endTime($next['time'], $duration),
        'price_label' => $space_data['price_label'],
        'capacity_meta' => $space_data['capacity_meta'],
        'book_url' => $book_url,
      ];
    }
    return $slots;
  }

  /**
   * Which space ids the current user can quick-book directly — same
   * eligibility check as buildNextSlots(), exposed separately so the
   * widget's manually-picked date/time can also skip straight to
   * quick_book instead of only the one precomputed "next slot".
   *
   * @return array
   *   Map of space id => TRUE for eligible spaces only.
   */
  protected function eligibleSpaceIds(): array {
    if (!$this->currentUser()->isAuthenticated()) {
      return [];
    }
    $eligible = $this->bookingCreator->eligibleSpaces($this->currentUser()->getRoles());
    return array_fill_keys(array_keys($eligible), TRUE);
  }

  /**
   * Builds the full 14-day availability matrix per space, so the homepage
   * booking widget's Date/Time cards can be clicked open into a real picker
   * instead of only ever showing the single precomputed "next slot" — same
   * underlying data (AvailabilityChecker::buildMatrix()) as the full
   * /booking form, just embedded three times (one per space, tab-switched
   * client-side with no page reload).
   *
   * @return array
   *   Keyed by space id, each entry: days, time_slots, durations,
   *   durations_json, matrix_json, duration_hours_json, default_duration.
   */
  protected function buildSpacePickers(): array {
    $days = $this->next14Days();
    $pickers = [];

    foreach ($this->contentRepository->getSpaces() as $space_data) {
      $durations = $space_data['slot_durations'] ?: array_keys(AvailabilityChecker::DURATION_HOURS);
      $space_node = $this->cfcEntityTypeManager->getStorage('node')->load($space_data['nid']);
      $matrix = $space_node
        ? $this->availabilityChecker->buildMatrix($space_node, array_column($days, 'iso'), AvailabilityChecker::TIME_SLOTS, $durations)
        : [];

      $pickers[$space_data['id']] = [
        'days' => $days,
        'durations' => $durations,
        'matrix' => $matrix,
        'default_duration' => $durations[0] ?? '2 hours',
      ];
    }

    return $pickers;
  }

  /**
   * Returns the next 14 days as [iso, weekday, day, month] — same shape as
   * BookingForm::next14Days(), duplicated here since the homepage widget
   * needs the identical calendar independently of the full booking form.
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
   * "Today" / "Tomorrow" / "Tue 28" — matches the prototype's date styling.
   */
  protected function dayLabel(string $iso): string {
    $date = new \DateTime($iso);
    $today = new \DateTime('today');
    $diff = (int) $today->diff($date)->format('%r%a');

    if ($diff === 0) {
      return 'Today';
    }
    if ($diff === 1) {
      return 'Tomorrow';
    }
    return $date->format('D j');
  }

  /**
   * Adds a duration label's hours to a "HH:MM" start time.
   */
  protected function endTime(string $start, string $duration): string {
    [$hours, $minutes] = array_map('intval', explode(':', $start));
    $end = (new \DateTime())->setTime($hours, $minutes)
      ->modify('+' . (AvailabilityChecker::DURATION_HOURS[$duration] ?? 2) . ' hours');
    return $end->format('H:i');
  }

}
