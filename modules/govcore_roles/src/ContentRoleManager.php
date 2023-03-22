<?php

namespace Drupal\govcore_roles;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\EntityTypeManagerInterface;
use Drupal\user\PermissionHandlerInterface;

/**
 * A service for managing the configuration and deployment of content roles.
 *
 * @internal
 *   This is an internal part of GovCore Roles and may be changed or removed
 *   at any time without warning. External code should not interact with this
 *   class.
 */
final class ContentRoleManager {

  /**
   * The config factory.
   *
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private $configFactory;

  /**
   * The node type entity storage handler.
   *
   * @var \Drupal\Core\Entity\EntityStorageInterface
   */
  private $nodeTypeStorage;

  /**
   * The permissions handler service.
   *
   * @var \Drupal\user\PermissionHandlerInterface
   */
  private $permissionsHandler;

  /**
   * ContentRoleManager constructor.
   *
   * @param \Drupal\Core\Config\ConfigFactoryInterface $config_factory
   *   The config factory.
   * @param \Drupal\Core\Entity\EntityTypeManagerInterface $entity_type_manager
   *   The entity type manager.
   * @param \Drupal\user\PermissionHandlerInterface $permissions_handler
   *   The permissions handler service.
   */
  public function __construct(ConfigFactoryInterface $config_factory, EntityTypeManagerInterface $entity_type_manager, PermissionHandlerInterface $permissions_handler) {
    $this->configFactory = $config_factory;
    $this->nodeTypeStorage = $entity_type_manager->getStorage('node_type');
    $this->permissionsHandler = $permissions_handler;
  }

  /**
   * Grants permissions (or meta-permissions) to a content role.
   *
   * @param string $role_id
   *   The content role ID.
   * @param string[] $permissions
   *   The permissions to grant. Can contain the '?' token, which will be
   *   replaced with the node type ID.
   *
   * @return $this
   *   The called object, for chaining.
   */
  public function grantPermissions($role_id, array $permissions) {
    $key = "content_roles.{$role_id}";

    $config = $this->configFactory->getEditable('govcore_roles.settings');

    // Add the raw permissions to the content role.
    $role = $config->get($key);
    $role['permissions'] = array_merge($role['permissions'], $permissions);
    $config->set($key, $role)->save();

    $all_permissions = array_keys($this->permissionsHandler->getPermissions());

    if ($role['enabled']) {
      // Look up all node type IDs.
      $node_types = $this->nodeTypeStorage->getQuery()->execute();

      foreach ($node_types as $node_type) {
        $permissions = str_replace('?', $node_type, $role['permissions']);
        // Only grant permissions that actually exist.
        $permissions = array_intersect($permissions, $all_permissions);
        user_role_grant_permissions($node_type . '_' . $role_id, $permissions);
      }
    }
    return $this;
  }

}
