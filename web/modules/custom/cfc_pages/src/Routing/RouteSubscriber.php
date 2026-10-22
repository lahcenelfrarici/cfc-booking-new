<?php

namespace Drupal\cfc_pages\Routing;

use Drupal\Core\Routing\RouteSubscriberBase;
use Symfony\Component\Routing\RouteCollection;

/**
 * Points Drupal core's own /user/login route at our themed sign-in page
 * instead of its default unstyled form — anything that redirects an
 * anonymous visitor to "please log in" via the standard core mechanism
 * (e.g. access-denied redirects with ?destination=...) uses this route
 * name, not our cfc_pages.sign_in, so overriding it here is the only way
 * to make every such path land on the real design.
 */
class RouteSubscriber extends RouteSubscriberBase {

  /**
   * {@inheritdoc}
   */
  protected function alterRoutes(RouteCollection $collection): void {
    if ($route = $collection->get('user.login')) {
      // Same controller method as cfc_pages.sign_in, not a redirect to it —
      // a RedirectResponse here would get its target silently rewritten by
      // core's RedirectResponseSubscriber whenever the incoming request
      // carries ?destination=..., bypassing this page entirely (confirmed
      // via a live test: a redirect to /sign-in?destination=/booking came
      // back as a redirect straight to /booking, login prompt skipped).
      // Returning the page content directly isn't a RedirectResponse, so
      // that subscriber never triggers — the real login form still honors
      // ?destination=... normally on successful submission, since that's
      // core's own intended use of the mechanism.
      $route->setDefault('_controller', '\Drupal\cfc_pages\Controller\SignInController::build');
      $route->setDefault('_title', 'Sign in');
    }
  }

}
