<?php

namespace Drupal\Tests\govcore_core\Kernel;

use Drupal\Core\Extension\Extension;
use Drupal\KernelTests\KernelTestBase;
use Drupal\govcore_core\ComponentDiscovery;

/**
 * @group govcore
 * @group govcore_core
 *
 * @coversDefaultClass \Drupal\govcore_core\ComponentDiscovery
 */
class ComponentDiscoveryTest extends KernelTestBase {

  /**
   * The ComponentDiscovery under test.
   *
   * @var \Drupal\govcore\ComponentDiscovery
   */
  protected $discovery;

  /**
   * {@inheritdoc}
   */
  protected function setUp() {
    parent::setUp();

    $this->discovery = new ComponentDiscovery(
      $this->container->get('app.root')
    );
  }

  /**
   * @covers ::getAll
   */
  public function testGetAll() {
    $components = $this->discovery->getAll();

    $this->assertInstanceOf(Extension::class, $components['govcore_core']);
    $this->assertInstanceOf(Extension::class, $components['govcore_search']);
    $this->assertArrayNotHasKey('panels', $components);
    $this->assertArrayNotHasKey('views', $components);
  }

  /**
   * @covers ::getMainComponents
   */
  public function testGetMainComponents() {
    $components = $this->discovery->getMainComponents();

    $this->assertInstanceOf(Extension::class, $components['govcore_core']);

    $this->assertArrayNotHasKey('govcore_contact_form', $components);
    $this->assertArrayNotHasKey('govcore_page', $components);
    $this->assertArrayNotHasKey('govcore_roles', $components);
    $this->assertArrayNotHasKey('govcore_search', $components);
  }

  /**
   * @covers ::getSubComponents
   */
  public function testGetSubComponents() {
    $components = $this->discovery->getSubComponents();

    $this->assertInstanceOf(Extension::class, $components['govcore_contact_form']);
    $this->assertInstanceOf(Extension::class, $components['govcore_page']);
    $this->assertInstanceOf(Extension::class, $components['govcore_roles']);
    $this->assertInstanceOf(Extension::class, $components['govcore_search']);
    $this->assertArrayNotHasKey('govcore_core', $components);
  }

}
