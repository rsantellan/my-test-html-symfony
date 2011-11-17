<?php

/**
 * mdCurrencyConvertion filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdCurrencyConvertionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'ratio'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'ratio'         => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_currency_convertion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdCurrencyConvertion';
  }

  public function getFields()
  {
    return array(
      'currency_from' => 'Number',
      'currency_to'   => 'Number',
      'ratio'         => 'Text',
    );
  }
}
