<?php

namespace Drupal\govcore_core;

use Drupal\Core\Extension\Extension;
use Drupal\Core\Extension\ExtensionDiscovery;

/**
 * Helper object to locate GovCore components and sub-components.
 */
class ComponentDiscovery {

  /**
   * Prefix that GovCore components are expected to start with.
   */
  const COMPONENT_PREFIX = 'govcore_';

  /**
   * The extension discovery iterator.
   *
   * @var \Drupal\Core\Extension\ExtensionDiscovery
   */
  protected $discovery;

  /**
   * The GovCore profile extension object.
   *
   * @var \Drupal\Core\Extension\Extension
   */
  protected $profile;

  /**
   * Cache of all discovered components.
   *
   * @var \Drupal\Core\Extension\Extension[]
   */
  protected $components;

  /**
   * ComponentDiscovery constructor.
   *
   * @param string $app_root
   *   The application root directory.
   */
  public function __construct($app_root) {
    $this->discovery = new ExtensionDiscovery($app_root);
  }

  /**
   * Returns an extension object for the GovCore profile.
   *
   * @return \Drupal\Core\Extension\Extension
   *   The GovCore profile extension object.
   *
   * @throws \RuntimeException
   *   If the GovCore profile is not found in the system.
   */
  protected function getProfile() {
    if (empty($this->profile)) {
      $profiles = $this->discovery->scan('profile');

      if (empty($profiles['govcore'])) {
        throw new \RuntimeException('GovCore profile not found.');
      }
      $this->profile = $profiles['govcore'];
    }
    return $this->profile;
  }

  /**
   * Returns extension objects for all GovCore components.
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   Array of extension objects for all GovCore components.
   */
  public function getAll() {
    if (is_null($this->components)) {
      $identifier = self::COMPONENT_PREFIX;

      $filter = function (Extension $module) use ($identifier) {
        return strpos($module->getName(), $identifier) === 0;
      };

      $this->components = array_filter($this->discovery->scan('module'), $filter);
    }
    return $this->components;
  }

  /**
   * Returns extension objects for all main GovCore components.
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   Array of extension objects for top-level GovCore components.
   */
  public function getMainComponents() {
    $identifier = self::COMPONENT_PREFIX;

    $filter = function (Extension $module) use ($identifier) {
      // Assumes that:
      // 1. GovCore sub-components are always in a sub-directory within the
      //    main component.
      // 2. The main component's directory starts with "govcore_".
      // E.g.: "/govcore_core/modules/govcore_search".
      $path = explode(DIRECTORY_SEPARATOR, $module->getPath());
      $parent = $path[count($path) - 3];
      return strpos($parent, $identifier) !== 0;
    };

    return array_filter($this->getAll(), $filter);
  }

  /**
   * Returns extension object for all GovCore sub-components.
   *
   * @return \Drupal\Core\Extension\Extension[]
   *   Array of extension objects for GovCore sub-components.
   */
  public function getSubComponents() {
    return array_diff_key($this->getAll(), $this->getMainComponents());
  }

}
