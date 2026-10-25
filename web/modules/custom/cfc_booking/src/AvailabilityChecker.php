<?php

namespace Drupal\cfc_booking;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * Checks whether a Space is free for a given date/time/duration.
 *
 * MVP rule: a Space with field_concurrent_capacity = 0 (Desk) has no
 * capacity limit — always free. Any other Space (Meeting Room, Studio) is
 * single-occupancy: any overlapping non-cancelled booking blocks the slot.
 */
class AvailabilityChecker {

  public const DURATION_HOURS = [
    '1 hour' => 1,
    '2 hours' => 2,
    'Half day (4h)' => 4,
    'Full day (8h)' => 8,
  ];

  // Full business-hours grid, 09:00 through 18:00 (closing). 17:00 and 18:00
  // can never start a valid booking (the shortest duration is 2 hours and
  // closing is 18:00), so they always come back disabled from the standard
  // closing-time check in isFree()/buildMatrix() — same logic path as every
  // other slot, rather than a separate hardcoded placeholder, so the picker
  // shows one consistent available/disabled state across the whole day.
  // Shared by BookingForm (calendar) and findNextAvailable() (homepage "next
  // slot" blocks) — one source of truth.
  public const TIME_SLOTS = ['09:00', '10:00', '11:00', '12:00', '13:00', '14:00', '15:00', '16:00', '17:00', '18:00'];

  // Kept for backward compatibility with callers still wiring this through
  // (BookingForm, the booking-datetime-picker component) — now empty since
  // 17:00/18:00 are real slots in TIME_SLOTS above.
  public const PHANTOM_TIME_SLOTS = [];

  /**
   * The establishment closes at 18:00 — no booking may extend past this,
   * regardless of space capacity (applies to Desk too).
   */
  protected const CLOSING_MINUTES = 18 * 60;

  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Returns TRUE if the space is free for the requested date/time/duration.
   */
  public function isFree(NodeInterface $space, string $date, string $timeSlot, string $duration, ?int $excludeBookingId = NULL): bool {
    if (!$this->isDurationAllowedForSlot($timeSlot, $duration)) {
      return FALSE;
    }

    [$newStart, $newEnd] = $this->toRange($timeSlot, $duration);
    if ($newEnd > self::CLOSING_MINUTES) {
      return FALSE;
    }

    if ($this->isPastToday($date, $newStart)) {
      return FALSE;
    }

    if ((int) $space->get('field_concurrent_capacity')->value === 0) {
      return TRUE;
    }

    foreach ($this->bookedRanges($space, $date, $excludeBookingId) as [$existingStart, $existingEnd]) {
      if ($newStart < $existingEnd && $existingStart < $newEnd) {
        return FALSE;
      }
    }

    return TRUE;
  }

  /**
   * Builds a full availability matrix for a space across the given dates,
   * time slots and durations — used to populate a date/time picker without
   * a query per cell (one query per date instead).
   *
   * @return array
   *   [date => [timeSlot => [duration => bool free]]]
   */
  public function buildMatrix(NodeInterface $space, array $dates, array $timeSlots, array $durations): array {
    $unlimited = (int) $space->get('field_concurrent_capacity')->value === 0;

    $matrix = [];
    foreach ($dates as $date) {
      $ranges = $unlimited ? [] : $this->bookedRanges($space, $date);
      $matrix[$date] = [];
      foreach ($timeSlots as $slot) {
        $matrix[$date][$slot] = [];
        foreach ($durations as $duration) {
          if (!$this->isDurationAllowedForSlot($slot, $duration)) {
            $matrix[$date][$slot][$duration] = FALSE;
            continue;
          }
          [$start, $end] = $this->toRange($slot, $duration);
          if ($end > self::CLOSING_MINUTES || $this->isPastToday($date, $start)) {
            $matrix[$date][$slot][$duration] = FALSE;
            continue;
          }
          $free = TRUE;
          foreach ($ranges as [$existingStart, $existingEnd]) {
            if ($start < $existingEnd && $existingStart < $end) {
              $free = FALSE;
              break;
            }
          }
          $matrix[$date][$slot][$duration] = $free;
        }
      }
    }
    return $matrix;
  }

  /**
   * Finds the first free [date, time] slot for a space/duration, starting
   * today — used by the homepage "next available slot" blocks. Stops at the
   * first hit instead of building a full matrix (buildMatrix()'s job when
   * the caller needs the whole grid, e.g. the booking calendar).
   *
   * @return array{date: string, time: string}|null
   */
  public function findNextAvailable(NodeInterface $space, string $duration, int $daysAhead = 14): ?array {
    $unlimited = (int) $space->get('field_concurrent_capacity')->value === 0;
    $now = new \DateTime('now');
    $today = (clone $now)->setTime(0, 0);

    for ($i = 0; $i < $daysAhead; $i++) {
      $date = (clone $today)->modify("+$i days");
      $iso = $date->format('Y-m-d');
      $ranges = $unlimited ? [] : $this->bookedRanges($space, $iso);

      foreach (self::TIME_SLOTS as $slot) {
        if (!$this->isDurationAllowedForSlot($slot, $duration)) {
          continue;
        }
        [$start, $end] = $this->toRange($slot, $duration);
        if ($end > self::CLOSING_MINUTES || $this->isPastToday($iso, $start)) {
          continue;
        }
        $free = TRUE;
        foreach ($ranges as [$existingStart, $existingEnd]) {
          if ($start < $existingEnd && $existingStart < $end) {
            $free = FALSE;
            break;
          }
        }
        if ($free) {
          return ['date' => $iso, 'time' => $slot];
        }
      }
    }
    return NULL;
  }

  /**
   * Returns the [startMinutes, endMinutes] ranges of existing non-cancelled
   * bookings for a space on a given date (one query).
   */
  protected function bookedRanges(NodeInterface $space, string $date, ?int $excludeBookingId = NULL): array {
    $storage = $this->entityTypeManager->getStorage('node');
    $query = $storage->getQuery()
      ->condition('type', 'booking')
      ->condition('field_space', $space->id())
      ->condition('field_booking_date', $date)
      ->condition('field_status', 'cancelled', '<>')
      ->accessCheck(FALSE);
    if ($excludeBookingId) {
      $query->condition('nid', $excludeBookingId, '<>');
    }
    $existing_ids = $query->execute();

    $ranges = [];
    foreach ($storage->loadMultiple($existing_ids) as $existing) {
      $ranges[] = $this->toRange(
        $existing->get('field_time_slot')->value,
        $existing->get('field_duration')->value
      );
    }
    return $ranges;
  }

  /**
   * TRUE if $date is today and $startMinutes has already passed — a slot
   * that's technically unbooked but already started can't be reserved.
   * Shared by isFree(), buildMatrix() and findNextAvailable() so the
   * calendar grid, the submit-time check and the "next available slot"
   * widget always agree on what counts as bookable today.
   */
  protected function isPastToday(string $date, int $startMinutes): bool {
    $now = new \DateTime('now');
    if ($date !== $now->format('Y-m-d')) {
      return FALSE;
    }
    return $startMinutes <= ((int) $now->format('H') * 60 + (int) $now->format('i'));
  }

  /**
   * A "Full day (8h)" booking must start at opening (09:00) — closing time
   * alone would also let it start at 10:00 (10:00 + 8h = 18:00 exactly), but
   * a "full day" is meant to span the whole business day, not just any 8h
   * window that happens to fit. Every other duration is only bound by the
   * closing-time check in the caller.
   */
  protected function isDurationAllowedForSlot(string $timeSlot, string $duration): bool {
    if ($duration === 'Full day (8h)') {
      return $timeSlot === '09:00';
    }
    return TRUE;
  }

  /**
   * Converts a "HH:MM" + duration label into a [startMinutes, endMinutes] range.
   */
  protected function toRange(string $timeSlot, string $duration): array {
    [$hours, $minutes] = array_map('intval', explode(':', $timeSlot) + [0, 0]);
    $start = $hours * 60 + $minutes;
    $end = $start + (self::DURATION_HOURS[$duration] ?? 1) * 60;
    return [$start, $end];
  }

  /**
   * Formats a "HH:MM" start time + duration label as a "HH:MM - HH:MM"
   * clock-time range — used wherever a booking's time needs to show exactly
   * when it ends, not just a start time + an abstract duration label (e.g.
   * "15:00 - 17:00" instead of just "15:00").
   *
   * "Full day" is always shown ending at closing time (18:00) rather than
   * the literal start+8h arithmetic (which would read e.g. "09:00 - 17:00")
   * — it's meant to read as the whole business day, same rule the public
   * booking-datetime-picker component's own endTime() already applies;
   * this was the one place still doing the literal math instead (confirmed
   * in a live screenshot — the backoffice "locked" summary showed
   * "09:00 - 17:00" for a Full day booking that starts at 09:00).
   */
  public static function formatTimeRange(string $timeSlot, string $duration): string {
    [$hours, $minutes] = array_map('intval', explode(':', $timeSlot) + [0, 0]);
    $start = $hours * 60 + $minutes;
    $end = $duration === 'Full day (8h)' ? self::CLOSING_MINUTES : $start + (self::DURATION_HOURS[$duration] ?? 1) * 60;
    return sprintf('%02d:%02d - %02d:%02d', intdiv($start, 60), $start % 60, intdiv($end, 60), $end % 60);
  }

}
