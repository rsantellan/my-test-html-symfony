<?php

/**
 * mdCurrencyConvertion form base class.
 *
 * @method mdCurrencyConvertion getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdCurrencyConvertionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'currency_from' => new sfWidgetFormInputHidden(),
      'currency_to'   => new sfWidgetFormInputHidden(),
      'ratio'         => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'currency_from' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('currency_from')), 'empty_value' => $this->getObject()->get('currency_from'), 'required' => false)),
      'currency_to'   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('currency_to')), 'empty_value' => $this->getObject()->get('currency_to'), 'required' => false)),
      'ratio'         => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('md_currency_convertion[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdCurrencyConvertion';
  }

}
