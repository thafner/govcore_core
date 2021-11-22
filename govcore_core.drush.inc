<?php

/**
 * @file
 * Drush integration for GovCore.
 */

/**
 * Implements drush_hook_COMMAND_validate().
 */
function drush_govcore_core_pm_updatecode_validate() {
  $govcore_path = Drupal::moduleHandler()->getModule('govcore')->getPath();

  $question = dt('Updating code with Drush can potentially break your GovCore site. (See @path for safe update instructions.) Are you SURE you want to continue?', [
    '@path' => Drupal::root() . "/$govcore_path/UPDATE.md",
  ]);
  return drush_confirm($question);
}

/**
 * Implements drush_hook_pre_COMMAND().
 */
function drush_govcore_core_pre_updatedb() {
  // A common cause of errors during database updates is update hooks referring
  // to new or changed plugin definitions. Clearing all plugin caches before
  // updates begin ensures that the plugin system always has the latest plugin
  // definitions to work with.
  if (Drupal::hasContainer()) {
    Drupal::service('plugin.cache_clearer')->clearCachedDefinitions();
  }
}
