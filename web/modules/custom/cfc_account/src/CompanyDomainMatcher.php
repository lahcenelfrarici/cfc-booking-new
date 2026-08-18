<?php

namespace Drupal\cfc_account;

use Drupal\taxonomy\TermInterface;

/**
 * Validates the professional email address used for CFC Member registration.
 */
class CompanyDomainMatcher {

  /**
   * Email domains rejected as "not a professional address".
   */
  protected const GENERIC_DOMAINS = ['gmail.com', 'yahoo.com', 'hotmail.com', 'outlook.com', 'icloud.com', 'live.com'];

  /**
   * Validates a CFC Member's professional email.
   *
   * @param string $email
   *   The submitted email address.
   * @param \Drupal\taxonomy\TermInterface|null $company
   *   The selected company term, or NULL if entered manually.
   *
   * @return string|null
   *   A human-readable error message, or NULL if the email is valid.
   */
  public function validate(string $email, ?TermInterface $company): ?string {
    $domain = strtolower(trim(substr(strrchr($email, '@') ?: '', 1)));

    if ($domain === '' || !str_contains($email, '@')) {
      return 'Please enter a valid email address.';
    }

    if (in_array($domain, self::GENERIC_DOMAINS, TRUE)) {
      return 'Please use a professional email address. Generic providers (Gmail, Yahoo, Hotmail, Outlook, iCloud, Live) are not accepted.';
    }

    if ($company && $company->hasField('field_company_domain') && !$company->get('field_company_domain')->isEmpty()) {
      $expected = strtolower((string) $company->get('field_company_domain')->value);
      if ($domain !== $expected) {
        return "The email address must belong to the selected company's domain (expected @$expected).";
      }
    }

    return NULL;
  }

}
