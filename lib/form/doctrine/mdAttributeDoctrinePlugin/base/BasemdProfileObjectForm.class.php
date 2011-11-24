<?php

/**
 * mdProfileObject form base class.
 *
 * @method mdProfileObject getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdProfileObjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'object_id'         => new sfWidgetFormInputText(),
      'object_class_name' => new sfWidgetFormInputText(),
      'md_profile_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdProfile'), 'add_empty' => false)),
      'active'            => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_id'         => new sfValidatorInteger(),
      'object_class_name' => new sfValidatorString(array('max_length' => 64)),
      'md_profile_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdProfile'))),
      'active'            => new sfValidatorBoolean(),
    ));

    $this->widgetSchema->setNameFormat('md_profile_object[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProfileObject';
  }

}