<?php

namespace Drupal\Tests\govcore_core\Kernel\Update;

use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\UpdateManager;

/**
 * @group govcore_core
 */
class Update8006Test extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['govcore_core', 'system', 'user'];

  /**
   * {@inheritdoc}
   */
  protected $strictConfigSchema = FALSE;

  public function testUpdate() {
    module_load_install('govcore_core');
    govcore_core_update_8006();

    $config = $this->container->get('config.factory')
      ->get('govcore.versions');

    foreach (static::$modules as $module) {
      $this->assertSame(UpdateManager::VERSION_UNKNOWN, $config->get($module));
    }
  }

}
