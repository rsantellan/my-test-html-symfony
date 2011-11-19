<?php

/**
 * mdAttribute filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdAttributeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'type_class' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'requiered'  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'translated' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'name'       => new sfValidatorPass(array('required' => false)),
      'type_class' => new sfValidatorPass(array('required' => false)),
      'requiered'  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'translated' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('md_attribute_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdAttribute';
  }

  public function getFields()
  {
    return array(
      'id'         => 'Number',
      'name'       => 'Text',
      'type_class' => 'Text',
      'requiered'  => 'Number',
      'translated' => 'Boolean',
    );
  }
}
