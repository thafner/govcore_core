<?php

namespace Drupal\Tests\govcore_core\Kernel\Update;

use Drupal\govcore_core\UpdateManager;

/**
 * @group govcore_core
 */
class Update8007Test extends Update8006Test {

  public function testUpdate() {
    parent::testUpdate();
    govcore_core_update_8007();

    $factory = $this->container->get('config.factory');

    $this->assertFalse(
      $factory->get(UpdateManager::CONFIG_NAME)->isNew()
    );
    $this->assertTrue(
      $factory->get('govcore.versions')->isNew()
    );
  }

}
