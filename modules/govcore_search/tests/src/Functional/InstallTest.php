<?php

namespace Drupal\Tests\govcore_search\Functional;

use Drupal\search_api\Entity\Index;
use Drupal\search_api\Entity\Server;
use Drupal\Tests\BrowserTestBase;

/**
 * Tests GovCore Search's install-time logic.
 *
 * @group govcore_search
 * @group govcore_core
 */
class InstallTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = ['node'];

  /**
   * Tests installing GovCore Search.
   */
  public function testInstall(): void {
    // Create a content type before installing, which should be added to the
    // index automatically.
    $node_type = $this->drupalCreateContentType();

    $this->container->get('module_installer')->install(['govcore_search']);

    // Search API DB should be installed, and the database server should have
    // been created and associated with the content index.
    $this->assertInstanceOf(Server::class, Server::load('database'));
    $index = Index::load('content');
    $this->assertInstanceOf(Index::class, $index);
    $this->assertTrue($index->status());
    $this->assertSame('database', $index->getServerId());
    // The index's rendered entity field should be aware of the existing content
    // type.
    // @see govcore_search_node_type_insert()
    $field = $index->getField('rendered')->getConfiguration();
    $this->assertArrayHasKey($node_type->id(), $field['view_mode']['entity:node']);

    // If we disable the index and add another content type, it should not cause
    // a problem.
    $index->disable()->save();
    $this->drupalCreateContentType();
  }

}
