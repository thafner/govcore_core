<?php

namespace Drupal\govcore_core\Form;

use Drupal\govcore_core\EntityDescriptionFormTrait;
use Drupal\user\RoleForm as BaseRoleForm;

/**
 * Adds description support to the user role entity form.
 */
class RoleForm extends BaseRoleForm {

  use EntityDescriptionFormTrait;

}
