<?php

/**
 * mdProduct form base class.
 *
 * @method mdProduct getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdProductForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                => new sfWidgetFormInputHidden(),
      'price'             => new sfWidgetFormInputText(),
      'quantity'          => new sfWidgetFormInputText(),
      'tax'               => new sfWidgetFormInputText(),
      'is_public'         => new sfWidgetFormInputCheckbox(),
      'md_unit_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'), 'add_empty' => false)),
      'md_currency_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdCurrency'), 'add_empty' => false)),
      'is_multiple'       => new sfWidgetFormInputCheckbox(),
      'weight'            => new sfWidgetFormInputText(),
      'volumetric_weight' => new sfWidgetFormInputText(),
      'priority'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'                => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'price'             => new sfValidatorPass(),
      'quantity'          => new sfValidatorInteger(array('required' => false)),
      'tax'               => new sfValidatorNumber(array('required' => false)),
      'is_public'         => new sfValidatorBoolean(array('required' => false)),
      'md_unit_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'))),
      'md_currency_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdCurrency'))),
      'is_multiple'       => new sfValidatorBoolean(array('required' => false)),
      'weight'            => new sfValidatorNumber(array('required' => false)),
      'volumetric_weight' => new sfValidatorNumber(array('required' => false)),
      'priority'          => new sfValidatorInteger(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_product[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProduct';
  }

}
