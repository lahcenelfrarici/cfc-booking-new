<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\cfc_booking\AvailabilityChecker;
use Drupal\Component\Utility\Html;
use Drupal\Core\Controller\ControllerBase;

/**
 * Usage statistics for bookings — counts, revenue and occupancy per space.
 *
 * Computed live from existing booking/space nodes on every request (no
 * separate stats storage to keep in sync) — the dataset is small enough
 * (one query per content type, loaded in full) that this stays fast without
 * needing a cache.
 */
class BookingStatsController extends ControllerBase {

  /**
   * Business hours span (09:00–18:00, same as AvailabilityChecker's grid)
   * — used as the "available hours per day" denominator for the monthly
   * occupancy-rate estimate below.
   */
  protected const OPEN_HOURS_PER_DAY = 9;

  public function build(): array {
    $node_storage = $this->entityTypeManager()->getStorage('node');

    $space_ids = $node_storage->getQuery()
      ->condition('type', 'space')
      ->condition('status', 1)
      ->sort('field_weight', 'ASC')
      ->accessCheck(FALSE)
      ->execute();

    $spaces = [];
    foreach ($node_storage->loadMultiple($space_ids) as $space_node) {
      $spaces[$space_node->id()] = [
        'title' => $space_node->label(),
        'unlimited' => (int) $space_node->get('field_concurrent_capacity')->value === 0,
        'bookings' => 0,
        'hours' => 0.0,
        'revenue' => 0.0,
      ];
    }

    $booking_ids = $node_storage->getQuery()
      ->condition('type', 'booking')
      ->accessCheck(FALSE)
      ->execute();

    $now = new \DateTime('now');
    $current_month = $now->format('Y-m');
    $currency = 'EUR';

    $total_active = 0;
    $total_cancelled = 0;
    $this_month_count = 0;
    $revenue_total = 0.0;
    $by_account_type = ['journalist' => 0, 'cfc_member' => 0, 'unknown' => 0];

    foreach ($node_storage->loadMultiple($booking_ids) as $booking) {
      if ($booking->get('field_status')->value === 'cancelled') {
        $total_cancelled++;
        continue;
      }
      $total_active++;

      $date = $booking->get('field_booking_date')->value;
      if ($date && str_starts_with($date, $current_month)) {
        $this_month_count++;
      }

      $account_type = $booking->get('field_booker_account_type')->value ?: 'unknown';
      $by_account_type[$account_type] = ($by_account_type[$account_type] ?? 0) + 1;

      $payment_status = $booking->get('field_payment_status')->value;
      $amount = (float) $booking->get('field_amount')->value;
      $is_paid = $payment_status === 'paid' && $amount > 0;
      if ($is_paid) {
        $revenue_total += $amount;
        $currency = $booking->get('field_currency')->value ?: $currency;
      }

      $space_id = $booking->get('field_space')->target_id;
      if (isset($spaces[$space_id])) {
        $duration = $booking->get('field_duration')->value;
        $spaces[$space_id]['bookings']++;
        $spaces[$space_id]['hours'] += AvailabilityChecker::DURATION_HOURS[$duration] ?? 0;
        if ($is_paid) {
          $spaces[$space_id]['revenue'] += $amount;
        }
      }
    }

    $available_hours_this_month = ((int) $now->format('t')) * self::OPEN_HOURS_PER_DAY;

    $most_booked = NULL;
    foreach ($spaces as $space) {
      if ($most_booked === NULL || $space['bookings'] > $most_booked['bookings']) {
        $most_booked = $space;
      }
    }

    $cards = [
      ['label' => $this->t('Active bookings'), 'value' => (string) $total_active],
      ['label' => $this->t('Bookings this month'), 'value' => (string) $this_month_count],
      ['label' => $this->t('Cancelled bookings'), 'value' => (string) $total_cancelled],
      ['label' => $this->t('Revenue collected'), 'value' => number_format($revenue_total, 2) . ' ' . $currency],
      [
        'label' => $this->t('Most requested space'),
        'value' => ($most_booked && $most_booked['bookings'] > 0) ? $most_booked['title'] : $this->t('—'),
      ],
      [
        'label' => $this->t('Journalist vs CFC Member'),
        'value' => $by_account_type['journalist'] . ' / ' . $by_account_type['cfc_member'],
      ],
    ];

    return [
      '#attached' => ['library' => ['cfc_booking/admin_stats']],
      'wrapper' => [
        '#type' => 'container',
        '#attributes' => ['class' => ['cfc-stats-scope']],
        'intro' => [
          '#markup' => '<p class="cfc-stats-intro">' . $this->t('Figures are computed live from current bookings. Occupancy is estimated over the current calendar month (@hours open hours/day).', ['@hours' => self::OPEN_HOURS_PER_DAY]) . '</p>',
        ],
        'cards' => $this->buildCardsMarkup($cards),
        'table' => $this->buildSpaceTableMarkup($spaces, $available_hours_this_month, $currency),
      ],
    ];
  }

  /**
   * Builds the top row of summary stat cards.
   */
  protected function buildCardsMarkup(array $cards): array {
    $html = '<div class="cfc-stats-cards">';
    foreach ($cards as $card) {
      $html .= '<div class="cfc-stats-card">'
        . '<div class="cfc-stats-card-value">' . Html::escape((string) $card['value']) . '</div>'
        . '<div class="cfc-stats-card-label">' . Html::escape((string) $card['label']) . '</div>'
        . '</div>';
    }
    $html .= '</div>';
    return ['#markup' => $html];
  }

  /**
   * Builds the per-space breakdown table (bookings, hours, occupancy, revenue).
   */
  protected function buildSpaceTableMarkup(array $spaces, int $available_hours_this_month, string $currency): array {
    $html = '<table class="cfc-stats-table"><thead><tr>'
      . '<th>' . $this->t('Space') . '</th>'
      . '<th>' . $this->t('Bookings') . '</th>'
      . '<th>' . $this->t('Hours booked') . '</th>'
      . '<th>' . $this->t('Occupancy (this month)') . '</th>'
      . '<th>' . $this->t('Revenue collected') . '</th>'
      . '</tr></thead><tbody>';

    foreach ($spaces as $space) {
      $occupancy = $space['unlimited']
        ? $this->t('N/A (unlimited)')
        : round(($space['hours'] / max($available_hours_this_month, 1)) * 100, 1) . '%';

      $html .= '<tr>'
        . '<td>' . Html::escape($space['title']) . '</td>'
        . '<td>' . (int) $space['bookings'] . '</td>'
        . '<td>' . rtrim(rtrim(number_format($space['hours'], 1), '0'), '.') . 'h</td>'
        . '<td>' . $occupancy . '</td>'
        . '<td>' . number_format($space['revenue'], 2) . ' ' . Html::escape($currency) . '</td>'
        . '</tr>';
    }
    $html .= '</tbody></table>';
    return ['#markup' => $html];
  }

}
