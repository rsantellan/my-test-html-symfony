<?php

/**
 * mdCategory form base class.
 *
 * @method mdCategory getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdCategoryForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                    => new sfWidgetFormInputHidden(),
      'label'                 => new sfWidgetFormInputText(),
      'object_class_name'     => new sfWidgetFormInputText(),
      'md_category_parent_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('mdCategory'), 'add_empty' => true)),
      'priority'              => new sfWidgetFormInputText(),
      'created_at'            => new sfWidgetFormDateTime(),
      'updated_at'            => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'label'                 => new sfValidatorString(array('max_length' => 255)),
      'object_class_name'     => new sfValidatorString(array('max_length' => 250)),
      'md_category_parent_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('mdCategory'), 'required' => false)),
      'priority'              => new sfValidatorInteger(array('required' => false)),
      'created_at'            => new sfValidatorDateTime(),
      'updated_at'            => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'mdCategory', 'column' => array('label')))
    );

    $this->widgetSchema->setNameFormat('md_category[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdCategory';
  }

}
