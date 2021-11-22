<?php

namespace Drupal\Tests\govcore_core\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\UpdateManager;

/**
 * @group govcore_core
 * @group orca_public
 */
class ModuleInstallTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['govcore_core', 'system', 'user'];

  public function testKnownVersion() {
    drupal_static_reset('system_get_info');

    $this->container->get('cache.default')
      ->set('system.module.info', [
        'fubar' => [
          'version' => '8.x-2.2',
        ],
      ]);

    govcore_core_modules_installed(['fubar']);

    $version = $this->container->get('config.factory')
      ->get(UpdateManager::CONFIG_NAME)
      ->get('fubar');

    $this->assertSame('2.2.0', $version);
  }

  /**
   * @depends testKnownVersion
   */
  public function testUnknownDiscoverableVersion() {
    $discovery = $this->prophesize('\Drupal\Component\Plugin\Discovery\DiscoveryInterface');

    $discovery->getDefinitions()->willReturn([
      'fubar:2.2.0' => [
        'id' => '2.2.0',
        'provider' => 'fubar',
      ],
      'fubar:2.3.0' => [
        'id' => '2.3.0',
        'provider' => 'fubar',
      ],
    ]);

    $this->container->set('govcore.update_manager', new UpdateManager(
      $this->container->get('container.namespaces'),
      $this->container->get('class_resolver'),
      $this->container->get('config.factory'),
      $this->container->get('extension.list.module'),
      $discovery->reveal()
    ));

    govcore_core_modules_installed(['fubar']);

    $version = $this->container->get('config.factory')
      ->get(UpdateManager::CONFIG_NAME)
      ->get('fubar');

    $this->assertSame('2.3.0', $version);
  }

  /**
   * @depends testUnknownDiscoverableVersion
   */
  public function testUnknownUndiscoverableVersion() {
    govcore_core_modules_installed(['fubar']);

    $version = $this->container->get('config.factory')
      ->get(UpdateManager::CONFIG_NAME)
      ->get('fubar');

    $this->assertSame(UpdateManager::VERSION_UNKNOWN, $version);
  }

}
