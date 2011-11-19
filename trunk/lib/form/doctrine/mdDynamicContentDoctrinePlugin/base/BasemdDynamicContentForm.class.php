<?php

/**
 * mdDynamicContent form base class.
 *
 * @method mdDynamicContent getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdDynamicContentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'publish_at'    => new sfWidgetFormDateTime(),
      'publish_up_to' => new sfWidgetFormDateTime(),
      'type_name'     => new sfWidgetFormInputText(),
      'priority'      => new sfWidgetFormInputText(),
      'is_public'     => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'publish_at'    => new sfValidatorDateTime(array('required' => false)),
      'publish_up_to' => new sfValidatorDateTime(array('required' => false)),
      'type_name'     => new sfValidatorString(array('max_length' => 128, 'required' => false)),
      'priority'      => new sfValidatorInteger(array('required' => false)),
      'is_public'     => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('md_dynamic_content[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdDynamicContent';
  }

}
