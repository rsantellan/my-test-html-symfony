<?php

/**
 * mdCategoryTranslation form.
 *
 * @package    plugin mdCategory
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdCategoryTranslationForm extends BasemdCategoryTranslationForm
{
  public function setup()
  {
    parent::setup();
    unset($this['slug']);
  }

  public function configure()
  {
      parent::configure();
  }
}
