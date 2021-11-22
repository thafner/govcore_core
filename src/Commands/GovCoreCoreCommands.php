<?php

namespace Drupal\govcore_core\Commands;

use Drupal\govcore_core\UpdateManager;
use Drush\Commands\DrushCommands;
use Drush\Style\DrushStyle;

/**
 * Exposes Drush commands provided by GovCore Core.
 */
class GovCoreCoreCommands extends DrushCommands {

  /**
   * The update manager service.
   *
   * @var \Drupal\govcore_core\UpdateManager
   */
  protected $updateManager;

  /**
   * GovCoreCoreCommands constructor.
   *
   * @param \Drupal\govcore_core\UpdateManager $update_manager
   *   The update manager service.
   */
  public function __construct(UpdateManager $update_manager) {
    $this->updateManager = $update_manager;
  }

  /**
   * Executes GovCore configuration updates from a specific version.
   *
   * @command update:govcore
   *
   * @usage update:govcore
   *   Runs all available configuration updates.
   */
  public function update() {
    $io = new DrushStyle($this->input(), $this->output());
    $this->updateManager->executeAllInConsole($io);
  }

}
