<?php

namespace Drupal\Tests\govcore_roles\Functional;

use Drupal\Tests\BrowserTestBase;

/**
 * @group govcore_roles
 * @group govcore_core
 * @group govcore
 * @group orca_public
 */
class ContentRoleFormTest extends BrowserTestBase {

  /**
   * {@inheritdoc}
   */
  protected $defaultTheme = 'stark';

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'govcore_core',
    'govcore_roles',
  ];

  public function test() {
    $account = $this->createUser([], NULL, TRUE);
    $this->drupalLogin($account);

    $this->drupalGet("/admin/config/system/govcore/roles");
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldExists('content_roles[reviewer]')->check();
    $this->assertSession()->buttonExists('Save configuration')->press();
    $this->assertSession()->statusCodeEquals(200);
    $this->assertSession()->fieldExists('content_roles[reviewer]')->uncheck();
    $this->assertSession()->buttonExists('Save configuration')->press();
    $this->assertSession()->statusCodeEquals(200);
  }

}
