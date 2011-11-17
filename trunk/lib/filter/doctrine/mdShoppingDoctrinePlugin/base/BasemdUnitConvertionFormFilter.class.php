<?php

/**
 * mdUnitConvertion filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdUnitConvertionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'from_unit' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit'), 'add_empty' => true)),
      'to_unit'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdUnit_2'), 'add_empty' => true)),
      'ratio'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'from_unit' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdUnit'), 'column' => 'id')),
      'to_unit'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdUnit_2'), 'column' => 'id')),
      'ratio'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
    ));

    $this->widgetSchema->setNameFormat('md_unit_convertion_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdUnitConvertion';
  }

  public function getFields()
  {
    return array(
      'id'        => 'Number',
      'from_unit' => 'ForeignKey',
      'to_unit'   => 'ForeignKey',
      'ratio'     => 'Number',
    );
  }
}
