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
    [$newStart, $newEnd] = $this->toRange($timeSlot, $duration);
    if ($newEnd > self::CLOSING_MINUTES) {
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
          [$start, $end] = $this->toRange($slot, $duration);
          if ($end > self::CLOSING_MINUTES) {
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
   * Converts a "HH:MM" + duration label into a [startMinutes, endMinutes] range.
   */
  protected function toRange(string $timeSlot, string $duration): array {
    [$hours, $minutes] = array_map('intval', explode(':', $timeSlot) + [0, 0]);
    $start = $hours * 60 + $minutes;
    $end = $start + (self::DURATION_HOURS[$duration] ?? 1) * 60;
    return [$start, $end];
  }

}
