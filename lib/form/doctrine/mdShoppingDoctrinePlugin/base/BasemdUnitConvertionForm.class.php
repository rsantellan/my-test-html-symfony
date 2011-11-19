<?php

/**
 * mdUnitConvertion form base class.
 *
 * @method mdUnitConvertion getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdUnitConvertionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'        => new sfWidgetFormInputHidden(),
      'from_unit' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'), 'add_empty' => false)),
      'to_unit'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit_2'), 'add_empty' => false)),
      'ratio'     => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'        => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'from_unit' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'))),
      'to_unit'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit_2'))),
      'ratio'     => new sfValidatorNumber(),
    ));

    $this->widgetSchema->setNameFormat('md_unit_convertion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdUnitConvertion';
  }

}
