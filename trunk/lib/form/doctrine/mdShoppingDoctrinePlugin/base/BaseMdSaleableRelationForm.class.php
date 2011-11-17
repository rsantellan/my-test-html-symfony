<?php

/**
 * MdSaleableRelation form base class.
 *
 * @method MdSaleableRelation getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseMdSaleableRelationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'md_saleable_parent_id' => new sfWidgetFormInputHidden(),
      'md_saleable_son_id'    => new sfWidgetFormInputHidden(),
    ));

    $this->setValidators(array(
      'md_saleable_parent_id' => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_saleable_parent_id')), 'empty_value' => $this->getObject()->get('md_saleable_parent_id'), 'required' => false)),
      'md_saleable_son_id'    => new sfValidatorChoice(array('choices' => array($this->getObject()->get('md_saleable_son_id')), 'empty_value' => $this->getObject()->get('md_saleable_son_id'), 'required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_saleable_relation[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'MdSaleableRelation';
  }

}
