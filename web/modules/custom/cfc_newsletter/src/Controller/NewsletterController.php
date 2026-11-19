<?php

namespace Drupal\cfc_newsletter\Controller;

use Drupal\Component\Serialization\Json;
use Drupal\Core\Controller\ControllerBase;
use Drupal\webform\Entity\WebformSubmission;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

/**
 * Handles AJAX submissions from the footer's "Stay informed" signup form.
 */
class NewsletterController extends ControllerBase {

  /**
   * TEMP DEBUG diagnostic route.
   */
  public function ping(): JsonResponse {
    return new JsonResponse(['pong' => TRUE]);
  }

  /**
   * Validates the posted email server-side and stores it as a webform
   * submission — resubscribing an already-stored address is a silent
   * no-op (still reports success) rather than a duplicate row.
   */
  public function subscribe(Request $request): JsonResponse {
    $data = Json::decode($request->getContent()) ?: [];
    $email = trim((string) ($data['email'] ?? ''));

    if ($email === '' || !\Drupal::service('email.validator')->isValid($email)) {
      return new JsonResponse(['success' => FALSE, 'message' => 'Please enter a valid email address.'], 422);
    }

    $storage = $this->entityTypeManager()->getStorage('webform_submission');
    foreach ($storage->loadByProperties(['webform_id' => 'newsletter']) as $submission) {
      if (strcasecmp((string) ($submission->getData()['email'] ?? ''), $email) === 0) {
        return new JsonResponse(['success' => TRUE]);
      }
    }

    WebformSubmission::create([
      'webform_id' => 'newsletter',
      'data' => ['email' => $email],
    ])->save();

    return new JsonResponse(['success' => TRUE]);
  }

}
