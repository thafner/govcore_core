<?php

namespace Drupal\Tests\govcore_contact_form\Kernel;

use Drupal\contact\Entity\ContactForm;
use Drupal\KernelTests\KernelTestBase;

/**
 * Tests install-time logic of GovCore Contact Form.
 *
 * @group govcore_contact_form
 * @group govcore_core
 * @group govcore
 *
 * @requires module contact_storage
 */
class InstallTest extends KernelTestBase {

  /**
   * {@inheritdoc}
   */
  protected static $modules = [
    'contact',
    'govcore_contact_form',
    'path_alias',
    'user',
  ];

  /**
   * Tests that the sitewide contact form is aliased correctly during install.
   */
  public function testAliasCreation() {
    $this->installEntitySchema('path_alias');

    // The sitewide contact form does not exist, so the install hook should not
    // try to create an alias for it.
    $this->container->get('module_handler')
      ->loadInclude('govcore_contact_form', 'install');
    // The hook will try to modify the contact form if config is not syncing.
    $this->container->get('config.installer')->setSyncing(TRUE);
    govcore_contact_form_install();

    /** @var \Drupal\path_alias\AliasManagerInterface $alias_manager */
    $alias_manager = $this->container->get('path_alias.manager');
    $this->assertSame('/contact', $alias_manager->getPathByAlias('/contact'));

    // If the contact form is created while installing from config (i.e.,
    // InstallerKernel::installationAttempted() returns TRUE and config is
    // syncing), the alias should be created too.
    $GLOBALS['install_state'] = [];
    ContactForm::create(['id' => 'sitewide'])->save();
    $this->assertSame('/contact/sitewide', $alias_manager->getPathByAlias('/contact'));
  }

}
