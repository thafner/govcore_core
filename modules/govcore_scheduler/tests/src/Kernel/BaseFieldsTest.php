<?php

namespace Drupal\Tests\govcore_scheduler\Kernel;

use Drupal\KernelTests\KernelTestBase;

/**
 * @group govcore_scheduler
 */
class BaseFieldsTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'content_moderation',
    'govcore_scheduler',
    'node',
    'workflows',
  ];

  public function testBaseFieldDefinitions() {
    /** @var \Drupal\Core\Field\FieldDefinitionInterface[] $field_definitions */
    $field_definitions = $this->container->get('entity_field.manager')
      ->getBaseFieldDefinitions('node');

    $this->assertEquals('Scheduled transition date', $field_definitions['scheduled_transition_date']->getLabel());
    $this->assertEquals('Scheduled transition state', $field_definitions['scheduled_transition_state']->getLabel());
  }

}
