<?php

/**
 * mdAttribute form base class.
 *
 * @method mdAttribute getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdAttributeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'name'       => new sfWidgetFormInputText(),
      'type_class' => new sfWidgetFormInputText(),
      'requiered'  => new sfWidgetFormInputText(),
      'translated' => new sfWidgetFormInputCheckbox(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'       => new sfValidatorString(array('max_length' => 100)),
      'type_class' => new sfValidatorString(array('max_length' => 100)),
      'requiered'  => new sfValidatorInteger(array('required' => false)),
      'translated' => new sfValidatorBoolean(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_attribute[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdAttribute';
  }

}
