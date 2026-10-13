<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\cfc_booking\AvailabilityChecker;
use Drupal\cfc_booking\BookingCreator;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Books a specific space/date/time/duration immediately — the homepage
 * "next available slot" blocks link here for a logged-in, eligible user,
 * skipping the space-choice + calendar steps since that choice is already
 * made by the slot shown there. Falls back to the normal /booking flow for
 * anything this can't safely fast-track (not logged in, not eligible for
 * this space, or the slot was taken in the meantime).
 *
 * No CSRF token on this route deliberately: the "not logged in" branch
 * redirects through sign-in and back via ?destination=, which crosses a
 * session boundary (anonymous → authenticated) — a token minted before
 * login would no longer validate after. The action itself is a booking
 * creation (not destructive — reviewable/cancellable afterward), and stays
 * behind real auth + eligibility + availability checks below, matching the
 * risk profile of similar "quick action" links elsewhere on the web.
 */
class QuickBookController extends ControllerBase {

  public function __construct(
    protected BookingCreator $bookingCreator,
    protected AvailabilityChecker $availabilityChecker,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('cfc_booking.creator'),
      $container->get('cfc_booking.availability_checker'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * Attempts the direct booking, falling back to the manual flow whenever
   * something isn't exactly as expected.
   */
  public function build(string $space, string $date, string $time, string $duration): RedirectResponse {
    $fallback_url = Url::fromRoute('cfc_pages.booking', [], ['query' => ['space' => $space]])->toString();

    if (!$this->currentUser()->isAuthenticated()) {
      $destination = Url::fromRoute('cfc_booking.quick_book', [
        'space' => $space,
        'date' => $date,
        'time' => $time,
        'duration' => $duration,
      ])->toString();
      return new RedirectResponse(
        Url::fromRoute('cfc_pages.sign_in', [], ['query' => ['destination' => $destination]])->toString()
      );
    }

    $spaces = $this->bookingCreator->eligibleSpaces($this->currentUser()->getRoles());
    $space_data = $spaces[$space] ?? NULL;
    if (!$space_data || !in_array($duration, $space_data['slot_durations'], TRUE)) {
      return new RedirectResponse($fallback_url);
    }

    // Same short-lived lock + real-time re-check as BookingForm::validateForm()
    // — the slot shown on the homepage may have been taken since that page
    // was cached/rendered. Scoped by account type too — see BookingForm for
    // why (separate availability pool per type on shared spaces like Studio).
    $account_type = $this->bookingCreator->accountTypeFromRoles($this->currentUser()->getRoles());
    $lock_name = 'cfc_booking:' . $space . ':' . $date . ':' . ($account_type ?? 'none');
    $lock = \Drupal::lock();
    if (!$lock->acquire($lock_name, 5)) {
      $this->messenger()->addStatus($this->t('That slot is being booked by someone else right now — please choose another.'));
      return new RedirectResponse($fallback_url);
    }

    $space_node = $this->cfcEntityTypeManager->getStorage('node')->load($space_data['nid']);
    if (!$this->availabilityChecker->isFree($space_node, $date, $time, $duration, NULL, $account_type)) {
      $lock->release($lock_name);
      $this->messenger()->addStatus($this->t('That slot was just taken — please choose another.'));
      return new RedirectResponse($fallback_url);
    }

    $booking = $this->bookingCreator->create($space_data, (int) $this->currentUser()->id(), $date, $time, $duration, $account_type);
    $lock->release($lock_name);

    $this->messenger()->addStatus($this->t('Reservation @ref created — please review the details below.', [
      '@ref' => (string) $booking->get('field_reference')->value,
    ]));
    return new RedirectResponse(Url::fromRoute('cfc_booking.review', ['node' => $booking->id()])->toString());
  }

}
