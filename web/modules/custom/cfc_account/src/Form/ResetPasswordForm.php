<?php

namespace Drupal\cfc_account\Form;

use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\RequestStack;

/**
 * "Forgot password" step 3: set a new password. Only reachable after
 * VerifyResetCodeForm set the 'cfc_reset_verified_uid' session flag — this
 * form doesn't re-check the code itself, it trusts that short-lived flag
 * (cleared the instant it's used, same one-time-use principle as the code).
 */
class ResetPasswordForm extends FormBase {

  public function __construct(
    protected RequestStack $cfcRequestStack,
    protected EntityTypeManagerInterface $cfcEntityTypeManager,
  ) {}

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container) {
    return new static(
      $container->get('request_stack'),
      $container->get('entity_type.manager'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function getFormId(): string {
    return 'cfc_account_reset_password_form';
  }

  /**
   * Returns the verified uid from the session, or NULL if there isn't one
   * or it's expired — shared by the controller (to decide whether to show
   * this form at all) and this form (to know who to actually update).
   */
  public function verifiedUid(): ?int {
    $session = $this->cfcRequestStack->getCurrentRequest()->getSession();
    $uid = $session->get('cfc_reset_verified_uid');
    $until = $session->get('cfc_reset_verified_until');
    if (!$uid || !$until || $until < \Drupal::time()->getRequestTime()) {
      return NULL;
    }
    return (int) $uid;
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state): array {
    $form['#attributes']['class'][] = 'space-y-4';

    $form['pass'] = [
      '#type' => 'password_confirm',
      '#size' => 25,
      '#required' => TRUE,
    ];

    $form['actions'] = ['#type' => 'actions'];
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Reset password'),
      '#attributes' => [
        'class' => ['w-full', 'bg-[#9F5434]', 'hover:bg-[#8A4A2E]', 'disabled:opacity-50', 'text-white', 'py-3.5', 'rounded-2xl', 'font-semibold', 'text-[14px]', 'transition-colors', 'mt-2'],
      ],
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state): void {
    if (!$this->verifiedUid()) {
      $form_state->setErrorByName('pass', $this->t('Your session has expired. Please start over.'));
    }
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state): void {
    $uid = $this->verifiedUid();
    $user = $this->cfcEntityTypeManager->getStorage('user')->load($uid);
    $user->setPassword((string) $form_state->getValue('pass'));
    $user->save();

    // One-time use — the flag is consumed the instant it's acted on, so
    // this form can't be resubmitted or revisited to reset the password
    // again without going through the code flow from scratch.
    $this->cfcRequestStack->getCurrentRequest()->getSession()->remove('cfc_reset_verified_uid');
    $this->cfcRequestStack->getCurrentRequest()->getSession()->remove('cfc_reset_verified_until');

    $form_state->setRedirectUrl(Url::fromRoute('cfc_pages.forgot_password_done'));
  }

}
