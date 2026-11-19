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

    $this->sendBookingEmail('booking_confirmation', $booking, $spaceData, $date, $time, $duration);

    return $booking;
  }

  /**
   * Updates an existing booking's space/date/time/duration (BookingForm's
   * edit mode, reached from "My Account") — re-snapshots price/amount the
   * same way create() does, since any of those four can change the total.
   * The caller is responsible for the availability lock/re-check
   * beforehand, same as create().
   */
  public function update(NodeInterface $booking, array $spaceData, string $date, string $time, string $duration): void {
    $is_paid = $spaceData['hourly_rate'] > 0;
    $amount = $is_paid ? $spaceData['hourly_rate'] * AvailabilityChecker::DURATION_HOURS[$duration] : NULL;

    $booking->set('title', $spaceData['title'] . ' — ' . $date . ' ' . $time);
    $booking->set('field_space', ['target_id' => $spaceData['nid']]);
    $booking->set('field_booking_date', $date);
    $booking->set('field_time_slot', $time);
    $booking->set('field_duration', $duration);
    $booking->set('field_price', $spaceData['price_label']);
    $booking->set('field_amount', $amount);
    $booking->set('field_currency', $is_paid ? $spaceData['currency'] : NULL);
    $booking->save();

    $this->sendBookingEmail('booking_updated', $booking, $spaceData, $date, $time, $duration);
  }

  /**
   * Emails the booker with the space, date, time and the Hub's address —
   * $key picks the wording (hook_mail's 'booking_confirmation' for a new
   * reservation, 'booking_updated' after a change) — silently skipped if
   * the account has no email (shouldn't happen in practice, but a
   * missing/placeholder admin-created account is not worth a hard failure
   * here).
   */
  protected function sendBookingEmail(string $key, NodeInterface $booking, array $spaceData, string $date, string $time, string $duration): void {
    $owner = $booking->getOwner();
    $email = $owner?->getEmail();
    if (!$email) {
      return;
    }

    $formatted_date = (new \DateTime($date))->format('l, j F Y');

    \Drupal::service('plugin.manager.mail')->mail(
      'cfc_booking',
      $key,
      $email,
      \Drupal::languageManager()->getDefaultLanguage()->getId(),
      [
        'space' => $spaceData['title'],
        'date' => $formatted_date,
        'time' => AvailabilityChecker::formatTimeRange($time, $duration),
        'reference' => (string) $booking->get('field_reference')->value,
      ],
    );
  }

}
