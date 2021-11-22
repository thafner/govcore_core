<?php

namespace Drupal\Tests\govcore_core\Kernel;

use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\UpdateManager;
use Prophecy\Argument;

/**
 * @group govcore_core
 */
class HooksTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['govcore_core', 'user'];

  public function testModulesInstalled() {
    $update_manager = $this->prophesize(UpdateManager::class);
    $update_manager->getVersion(Argument::any())->willReturn('1.0.0');
    $this->container->set('govcore.update_manager', $update_manager->reveal());

    govcore_core_modules_installed(['foo', 'bar']);

    // The stored versions should be sorted by key.
    $expected_versions = [
      'bar' => '1.0.0',
      'foo' => '1.0.0',
    ];
    $this->assertSame($expected_versions, $this->config('govcore_core.versions')->get());
  }

}
