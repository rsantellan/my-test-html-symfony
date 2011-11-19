<?php

/**
 * mdAttributeValue form base class.
 *
 * @method mdAttributeValue getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdAttributeValueForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'md_attribute_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttribute'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'md_attribute_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdAttribute'))),
    ));

    $this->widgetSchema->setNameFormat('md_attribute_value[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdAttributeValue';
  }

}
