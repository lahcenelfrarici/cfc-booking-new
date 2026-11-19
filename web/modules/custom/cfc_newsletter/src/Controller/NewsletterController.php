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
   * Validates the posted email server-side, stores it as a webform
   * submission, and emails the subscriber a short confirmation —
   * resubscribing an already-stored address is a silent no-op (still
   * reports success, no duplicate row, no duplicate email) rather than an
   * error.
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

    \Drupal::service('plugin.manager.mail')->mail(
      'cfc_newsletter',
      'subscribed',
      $email,
      \Drupal::languageManager()->getDefaultLanguage()->getId(),
    );

    return new JsonResponse(['success' => TRUE]);
  }

}
