<?php

namespace Drupal\cfc_pages\Plugin\Block;

use Drupal\Core\Block\Attribute\Block;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\Core\Extension\ThemeExtensionList;
use Drupal\Core\Menu\MenuLinkTreeInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Drupal\Core\StringTranslation\TranslatableMarkup;
use Drupal\Core\Url;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides the CFC Media Hub site footer.
 *
 * The four columns are real, admin-editable menus (footer-spaces,
 * footer-editorial, footer-production, footer-support) — see
 * /admin/structure/menu.
 */
#[Block(
  id: "cfc_footer",
  admin_label: new TranslatableMarkup("CFC Footer"),
)]
class CfcFooterBlock extends BlockBase implements ContainerFactoryPluginInterface {

  protected const FOOTER_MENUS = ['footer-spaces', 'footer-editorial', 'footer-production', 'footer-support'];

  public function __construct(
    array $configuration,
    $plugin_id,
    $plugin_definition,
    protected MenuLinkTreeInterface $menuTree,
    protected EntityTypeManagerInterface $entityTypeManager,
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
      $container->get('entity_type.manager'),
      $container->get('extension.list.theme'),
    );
  }

  /**
   * {@inheritdoc}
   */
  public function build() {
    $theme_path = $this->themeExtensionList->getPath('cfc_media_hub');
    $menu_storage = $this->entityTypeManager->getStorage('menu');

    $columns = [];
    $cache_tags = [];
    foreach (static::FOOTER_MENUS as $menu_id) {
      $menu = $menu_storage->load($menu_id);
      if (!$menu) {
        continue;
      }
      $cache_tags[] = 'config:system.menu.' . $menu_id;

      $parameters = $this->menuTree->getCurrentRouteMenuTreeParameters($menu_id);
      $tree = $this->menuTree->load($menu_id, $parameters);
      $tree = $this->menuTree->transform($tree, [
        ['callable' => 'menu.default_tree_manipulators:checkAccess'],
        ['callable' => 'menu.default_tree_manipulators:generateIndexAndSort'],
      ]);

      $links = [];
      foreach ($tree as $element) {
        if (!$element->access->isAllowed()) {
          continue;
        }
        $links[] = [
          'label' => $element->link->getTitle(),
          'url' => $element->link->getUrlObject()->toString(),
        ];
      }

      $columns[] = [
        'title' => $menu->label(),
        'links' => $links,
      ];
    }

    return [
      '#type' => 'component',
      '#component' => 'cfc_media_hub:footer',
      '#props' => [
        'home_url' => Url::fromRoute('<front>')->toString(),
        'logo_url' => base_path() . $theme_path . '/images/logo.png',
        'columns' => $columns,
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
    return array_merge(parent::getCacheContexts(), ['route']);
  }

}
