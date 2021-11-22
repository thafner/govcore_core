<?php

namespace Drupal\Tests\govcore_core\Kernel;

use Drupal\Core\Field\Entity\BaseFieldOverride;
use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\ConfigHelper;
use Drupal\Tests\node\Traits\ContentTypeCreationTrait;

/**
 * @group govcore_core
 *
 * @coversDefaultClass \Drupal\govcore_core\ConfigHelper
 */
class ConfigHelperTest extends KernelTestBase {

  use ContentTypeCreationTrait;

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'field',
    'node',
    'system',
    'text',
    'user',
  ];

  /**
   * @covers ::delete
   */
  public function testDelete() {
    $this->installConfig('node');

    $this->createContentType(['type' => 'page']);

    $base_field_override = BaseFieldOverride::create([
      'field_name' => 'promote',
      'entity_type' => 'node',
      'bundle' => 'page',
    ]);
    $base_field_override->save();

    ConfigHelper::forModule('node')->delete($base_field_override->getConfigDependencyName());
  }

}
