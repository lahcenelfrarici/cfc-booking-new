<?php

namespace Drupal\cfc_booking\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Url;
use Drupal\node\NodeInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Cancels a booking owned by the current user.
 */
class CancelBookingController extends ControllerBase {

  /**
   * Destinations the caller is allowed to request via ?destination=, beyond
   * the default (My Account). Kept to an explicit allow-list to avoid an
   * open redirect through a user-controlled query parameter.
   */
  protected const ALLOWED_DESTINATIONS = ['/booking'];

  /**
   * Cancels the booking and redirects back to My Account (or the requested
   * allow-listed destination, e.g. the Review page's "Edit reservation").
   */
  public function build(NodeInterface $node, Request $request): RedirectResponse {
    $account_url = Url::fromRoute('cfc_pages.account')->toString();
    $destination = $request->query->get('destination');
    $redirect_url = in_array($destination, self::ALLOWED_DESTINATIONS, TRUE) ? $destination : $account_url;

    if ($node->bundle() !== 'booking' || (int) $node->getOwnerId() !== (int) $this->currentUser()->id()) {
      $this->messenger()->addError($this->t('Reservation not found.'));
      return new RedirectResponse($account_url);
    }

    $node->set('field_status', 'cancelled');
    $node->save();
    $this->messenger()->addStatus($this->t('Reservation @ref has been cancelled.', [
      '@ref' => $node->get('field_reference')->value,
    ]));

    return new RedirectResponse($redirect_url);
  }

}
