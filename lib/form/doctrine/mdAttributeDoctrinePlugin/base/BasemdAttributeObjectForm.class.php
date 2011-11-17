<?php

/**
 * mdAttributeObject form base class.
 *
 * @method mdAttributeObject getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdAttributeObjectForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'object_id'             => new sfWidgetFormInputText(),
      'object_class_name'     => new sfWidgetFormInputText(),
      'md_attribute_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttribute'), 'add_empty' => false)),
      'md_attribute_value_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttributeValue'), 'add_empty' => true)),
      'value_non_translated'  => new sfWidgetFormInputText(),
      'md_profile_id'         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdProfile'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'object_id'             => new sfValidatorInteger(),
      'object_class_name'     => new sfValidatorString(array('max_length' => 128)),
      'md_attribute_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttribute'))),
      'md_attribute_value_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttributeValue'), 'required' => false)),
      'value_non_translated'  => new sfValidatorPass(array('required' => false)),
      'md_profile_id'         => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdProfile'))),
    ));

    $this->widgetSchema->setNameFormat('md_attribute_object[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdAttributeObject';
  }

}
