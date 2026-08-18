<?php

namespace Drupal\cfc_pages\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\Session\AccountProxyInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the CFC Media Hub site header (logo, nav, auth state, booking CTA).
 */
#[Block(
  id: "cfc_navbar",
  admin_label: new TranslatableMarkup("CFC Navbar"),
)]
class CfcNavbarBlock extends BlockBase implements ContainerFactoryPluginInterface {

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected MenuLinkTreeInterface $menuTree,
    protected AccountProxyInterface $currentUser,
    protected ThemeExtensionList $themeExtensionList,
  ) {
    parent::__construct($configuration, $plugin_id, $plugin_definition);
  }

  /**
   * {@inheritdoc}
   */
  public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition) {
    return new static(
      $configuration,
      $plugin_id,
      $plugin_definition,
      $container->get('menu.link_tree'),
      $container->get('current_user'),
      $container->get('extension.list.theme'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');
    $is_authenticated = $this->currentUser->isAuthenticated();

    $parameters = $this->menuTree->getCurrentRouteMenuTreeParameters('main');
    $parameters->setTopLevelOnly()->onlyEnabledLinks();
    $tree = $this->menuTree->load('main', $parameters);
    $tree = $this->menuTree->transform($tree, [
      ['callable' => 'menu.default_tree_manipulators:checkAccess'],
      ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
    ]);

    $links = [];
    $cache_tags = ['config:system.menu.main'];
    foreach ($tree as $element) {
      if (!$element->access->isAllowed()) {
        continue;
      }
      $link = $element->link;
      $links[] = [
        'label' => $link->getTitle(),
        'url' => $link->getUrlObject()->toString(),
        'active' => $element->inActiveTrail,
      ];
    }

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:navbar',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
        'links' => $links,
        'is_authenticated' => $is_authenticated,
        'account_url' => Url::fromRoute('cfc_pages.account')->toString(),
        'sign_in_url' => Url::fromRoute('cfc_pages.sign_in')->toString(),
        'booking_url' => Url::fromRoute('cfc_pages.booking')->toString(),
      ],
      '#cache' => [
        'tags' => $cache_tags,
      ],
    ];
  }

  /**
   * {@inheritdoc}
   */
  public function getCacheContexts() {
    return array_merge(parent::getCacheContexts(), ['route', 'user.roles:authenticated']);
  }

}
