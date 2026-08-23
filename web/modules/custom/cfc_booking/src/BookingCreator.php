<?php

namespace Drupal\cfc_booking;

use Drupal\cfc_content\ContentRepository;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\node\NodeInterface;

/**
 * The two pieces of booking business logic shared by BookingForm (the full
 * manual flow) and QuickBookController (direct booking from the homepage
 * "next available slot" blocks) — kept in one place instead of two copies
 * that could drift apart.
 */
class BookingCreator {

  public function __construct(
    protected ContentRepository $contentRepository,
    protected EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * Returns the Space data eligible for the given roles, keyed by machine
   * key ("desk"/"meeting"/"studio") so $spaces[$id] lookups work —
   * getSpaces() returns a plain sequential list.
   */
  public function eligibleSpaces(array $roles): array {
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
    return array_column($filtered, NULL, 'id');
  }

  /**
   * Creates a booking node, snapshotting the price/amount at booking time.
   *
   * The caller is responsible for the availability lock/real-time check
   * beforehand (BookingForm and QuickBookController each need different
   * error handling around that part — inline form error vs. a redirect).
   */
  public function create(array $spaceData, int $uid, string $date, string $time, string $duration): NodeInterface {
    $is_paid = $spaceData['hourly_rate'] > 0;
    $reference = 'RES-' . date('Y') . '-' . random_int(1000, 9999);
    $amount = $is_paid ? $spaceData['hourly_rate'] * AvailabilityChecker::DURATION_HOURS[$duration] : NULL;

    $booking = $this->entityTypeManager->getStorage('node')->create([
      'type' => 'booking',
      'title' => $spaceData['title'] . ' — ' . $date . ' ' . $time,
      'uid' => $uid,
      'field_space' => ['target_id' => $spaceData['nid']],
      'field_booking_date' => $date,
      'field_time_slot' => $time,
      'field_duration' => $duration,
      'field_guest_names' => [],
      'field_status' => 'upcoming',
      'field_reference' => $reference,
      'field_price' => $spaceData['price_label'],
      'field_amount' => $amount,
      'field_currency' => $is_paid ? $spaceData['currency'] : NULL,
      'field_payment_status' => $is_paid ? 'pending' : 'not_applicable',
      'status' => 1,
    ]);
    $booking->save();

    return $booking;
  }

}
