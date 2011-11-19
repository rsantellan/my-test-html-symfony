<?php

/**
 * mdProfileObject filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdProfileObjectFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'object_id'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'object_class_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'md_profile_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdProfile'), 'add_empty' => true)),
      'active'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
    ));

    $this->setValidators(array(
      'object_id'         => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'object_class_name' => new sfValidatorPass(array('required' => false)),
      'md_profile_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('mdProfile'), 'column' => 'id')),
      'active'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
    ));

    $this->widgetSchema->setNameFormat('md_profile_object_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProfileObject';
  }

  public function getFields()
  {
    return array(
      'id'                => 'Number',
      'object_id'         => 'Number',
      'object_class_name' => 'Text',
      'md_profile_id'     => 'ForeignKey',
      'active'            => 'Boolean',
    );
  }
}
