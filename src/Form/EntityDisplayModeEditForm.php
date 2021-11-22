<?php

namespace Drupal\govcore_core\Form;

use Drupal\field_ui\Form\EntityDisplayModeEditForm as BaseEntityDisplayModeEditForm;
use Drupal\govcore_core\EntityDescriptionFormTrait;

/**
 * Adds description support to the entity edit form for entity display modes.
 */
class EntityDisplayModeEditForm extends BaseEntityDisplayModeEditForm {

  use EntityDescriptionFormTrait;

}
