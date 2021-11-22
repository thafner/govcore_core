<?php

namespace Drupal\govcore_core\Form;

use Drupal\field_ui\Form\EntityDisplayModeAddForm as BaseEntityDisplayModeAddForm;
use Drupal\govcore_core\EntityDescriptionFormTrait;

/**
 * Adds description support to the entity add form for entity display modes.
 */
class EntityDisplayModeAddForm extends BaseEntityDisplayModeAddForm {

  use EntityDescriptionFormTrait;

}
