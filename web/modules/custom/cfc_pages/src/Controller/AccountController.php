<?php

namespace Drupal\cfc_pages\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Builds the account page for the current user.
 *
 * Profile identity (name/email) and reservations are both real, pulled from
 * the authenticated Drupal user and their "booking" nodes.
 */
class AccountController extends ControllerBase {

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
   * Builds the account page render array.
   */
  public function build(): array {
    $user = $this->currentUser();
    $display_name = $user->getDisplayName();
    $initials = $this->initialsFor($display_name);

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:account-page',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'booking_base_url' => Url::fromRoute('cfc_pages.booking')->toString(),
        'logout_url' => Url::fromRoute('user.logout')->toString(),
        'user_name' => $display_name,
        'user_email' => $user->getEmail() ?: '',
        'user_initials' => $initials,
        'reservations' => $this->loadReservations((int) $user->id()),
        'qr_svg' => $this->buildQrSvg(),
      ],
      '#cache' => [
        'contexts' => ['user'],
        'tags' => ['node_list:booking'],
      ],
    ];
  }

  /**
   * Loads the current user's bookings as plain arrays for the theme.
   */
  private function loadReservations(int $uid): array {
    $storage = $this->cfcEntityTypeManager->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('type', 'booking')
      ->condition('uid', $uid)
      ->sort('field_booking_date', 'DESC')
      ->accessCheck(TRUE)
      ->execute();

    $reservations = [];
    foreach ($storage->loadMultiple($ids) as $booking) {
      $space = $booking->get('field_space')->entity;
      $reservations[] = [
        'id' => (string) $booking->get('field_reference')->value,
        'space' => $space ? $space->label() : (string) $this->t('Unknown space'),
        'space_key' => $space ? (string) $space->get('field_machine_key')->value : '',
        'date' => (string) $booking->get('field_booking_date')->value,
        'time' => (string) $booking->get('field_time_slot')->value,
        'duration' => (string) $booking->get('field_duration')->value,
        'status' => (string) $booking->get('field_status')->value,
        'price' => (string) $booking->get('field_price')->value,
        'cancel_url' => Url::fromRoute('cfc_booking.cancel', ['node' => $booking->id()])->toString(),
      ];
    }
    return $reservations;
  }

  /**
   * Computes up to two uppercase initials from a display name.
   */
  private function initialsFor(string $name): string {
    $parts = preg_split('/\s+/', trim($name), -1, PREG_SPLIT_NO_EMPTY);
    $initials = array_map(static fn(string $part) => mb_strtoupper(mb_substr($part, 0, 1)), array_slice($parts, 0, 2));
    return implode('', $initials) ?: '?';
  }

  /**
   * Builds a decorative (non-scannable) QR-code-style SVG, deterministic per
   * render — ported from the prototype's canvas illustration.
   */
  private function buildQrSvg(int $size = 148): string {
    $n = 21;
    $cs = $size / $n;

    $finderCell = static function (int $r, int $c, int $or, int $oc) use (&$finderCell): bool {
      $lr = $r - $or;
      $lc = $c - $oc;
      if ($lr < 0 || $lr > 6 || $lc < 0 || $lc > 6) {
        return FALSE;
      }
      if ($lr === 0 || $lr === 6 || $lc === 0 || $lc === 6) {
        return TRUE;
      }
      return $lr >= 2 && $lr <= 4 && $lc >= 2 && $lc <= 4;
    };

    $isFilled = static function (int $r, int $c) use ($finderCell): bool {
      if ($r <= 7 && $c <= 7) {
        return ($r === 7 || $c === 7) ? FALSE : $finderCell($r, $c, 0, 0);
      }
      if ($r <= 7 && $c >= 13) {
        return ($r === 7 || $c === 13) ? FALSE : $finderCell($r, $c, 0, 14);
      }
      if ($r >= 13 && $c <= 7) {
        return ($r === 13 || $c === 7) ? FALSE : $finderCell($r, $c, 14, 0);
      }
      if ($r === 6 || $c === 6) {
        return ($r + $c) % 2 === 0;
      }
      $val = (($r * 73) ^ ($c * 37) ^ ($r * $c)) % 19;
      return $val < 10;
    };

    $rects = '';
    for ($r = 0; $r < $n; $r++) {
      for ($c = 0; $c < $n; $c++) {
        if ($isFilled($r, $c)) {
          $x = round($c * $cs + 0.5, 2);
          $y = round($r * $cs + 0.5, 2);
          $w = round($cs - 1, 2);
          $rx = round($cs * 0.1, 2);
          $rects .= sprintf('<rect x="%s" y="%s" width="%s" height="%s" rx="%s" fill="#111111" />', $x, $y, $w, $w, $rx);
        }
      }
    }

    return sprintf(
      '<svg width="%1$d" height="%1$d" viewBox="0 0 %1$d %1$d" xmlns="http://www.w3.org/2000/svg"><rect width="%1$d" height="%1$d" fill="white" rx="6" />%2$s</svg>',
      $size,
      $rects
    );
  }

}
