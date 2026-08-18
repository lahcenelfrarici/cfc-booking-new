<?php

namespace Drupal\cfc_payment\EventSubscriber;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\stripe\Event\StripeEvents;
use Drupal\stripe\Event\StripeWebhookEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Confirms booking payments from Stripe webhook events.
 *
 * This is the authoritative source of truth for field_payment_status.
 * PaymentForm's client-side check is only a fast-path UX shortcut — a card
 * can finish confirming after the user has already left the payment page
 * (3D Secure redirects, slow networks, closed tab, etc), so the webhook is
 * what actually settles the booking either way.
 */
class StripeWebhookSubscriber implements EventSubscriberInterface {

  public function __construct(
    protected EntityTypeManagerInterface $entityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function getSubscribedEvents(): array {
    return [
      StripeEvents::WEBHOOK => 'onWebhook',
    ];
  }

  /**
   * Reacts to payment_intent.succeeded / payment_intent.payment_failed.
   */
  public function onWebhook(StripeWebhookEvent $event): void {
    $stripe_event = $event->getEvent();

    if (!in_array($stripe_event->type, ['payment_intent.succeeded', 'payment_intent.payment_failed'], TRUE)) {
      return;
    }

    /** @var \Stripe\PaymentIntent $payment_intent */
    $payment_intent = $stripe_event->data->object;
    $storage = $this->entityTypeManager->getStorage('node');

    $node = NULL;
    $booking_id = $payment_intent->metadata['booking_id'] ?? NULL;
    if ($booking_id) {
      $candidate = $storage->load($booking_id);
      if ($candidate && $candidate->bundle() === 'booking') {
        $node = $candidate;
      }
    }

    // Fall back to matching by the stored PaymentIntent ID, in case the
    // metadata is ever missing.
    if (!$node) {
      $matches = $storage->loadByProperties([
        'type' => 'booking',
        'field_stripe_payment_intent' => $payment_intent->id,
      ]);
      $node = $matches ? reset($matches) : NULL;
    }

    if (!$node) {
      return;
    }

    $node->set('field_stripe_payment_intent', $payment_intent->id);
    $node->set('field_payment_status', $stripe_event->type === 'payment_intent.succeeded' ? 'paid' : 'failed');
    $node->save();
  }

}
