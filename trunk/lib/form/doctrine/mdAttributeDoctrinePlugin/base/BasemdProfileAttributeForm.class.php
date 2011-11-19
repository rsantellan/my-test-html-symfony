<?php

/**
 * mdProfileAttribute form base class.
 *
 * @method mdProfileAttribute getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdProfileAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_attribute_id' => new sfWidgetFormInputHidden(),
      'md_profile_id'   => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'md_attribute_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_attribute_id')), 'empty_value' => $this->getObject()->get('md_attribute_id'), 'required' => false)),
      'md_profile_id'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_profile_id')), 'empty_value' => $this->getObject()->get('md_profile_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_profile_attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProfileAttribute';
  }

}
