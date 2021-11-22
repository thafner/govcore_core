<?php

namespace Drupal\govcore_core;

/**
 * Provides a third-party settings implementation of EntityDescriptionInterface.
 */
trait ConfigEntityDescriptionTrait {

  /**
   * Implements EntityDescriptionInterface::getDescription().
   */
  public function getDescription() {
    return $this->getThirdPartySetting('govcore_core', 'description');
  }

  /**
   * Implements EntityDescriptionInterface::getDescription().
   */
  public function setDescription($description) {
    return $this->setThirdPartySetting('govcore_core', 'description', (string) $description);
  }

}
