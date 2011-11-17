<?php

/**
 * mdProduct filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdProductFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'price'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'quantity'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'tax'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_public'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'md_unit_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'), 'add_empty' => true)),
      'md_currency_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdCurrency'), 'add_empty' => true)),
      'is_multiple'       => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'weight'            => new sfWidgetFormFilterInput(),
      'volumetric_weight' => new sfWidgetFormFilterInput(),
      'priority'          => new sfWidgetFormFilterInput(),
    ));

    $this->setValidators(array(
      'price'             => new sfValidatorPass(array('required' => false)),
      'quantity'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'tax'               => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'is_public'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'md_unit_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdUnit'), 'column' => 'id')),
      'md_currency_id'    => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdCurrency'), 'column' => 'id')),
      'is_multiple'       => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'weight'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'volumetric_weight' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'priority'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('md_product_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProduct';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'price'             => 'Text',
      'quantity'          => 'Number',
      'tax'               => 'Number',
      'is_public'         => 'Boolean',
      'md_unit_id'        => 'ForeignKey',
      'md_currency_id'    => 'ForeignKey',
      'is_multiple'       => 'Boolean',
      'weight'            => 'Number',
      'volumetric_weight' => 'Number',
      'priority'          => 'Number',
    );
  }
}
