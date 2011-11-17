<?php

/**
 * mdProfileAttribute filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdProfileAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
    ));

    $this->setValidators(array(
    ));

    $this->widgetSchema->setNameFormat('md_profile_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProfileAttribute';
  }

  public function getFields()
  {
    return array(
      'md_attribute_id' => 'Number',
      'md_profile_id'   => 'Number',
    );
  }
}
