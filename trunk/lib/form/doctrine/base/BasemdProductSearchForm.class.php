<?php

/**
 * mdProductSearch form base class.
 *
 * @method mdProductSearch getObject() Returns the current form's model object
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasemdProductSearchForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'             => new sfWidgetFormInputHidden(),
      'lang'           => new sfWidgetFormInputText(),
      'name'           => new sfWidgetFormInputText(),
      'is_public'      => new sfWidgetFormInputCheckbox(),
      'descripcion'    => new sfWidgetFormTextarea(),
      'codigo'         => new sfWidgetFormTextarea(),
      'premios'        => new sfWidgetFormTextarea(),
      'presentaciones' => new sfWidgetFormTextarea(),
      'consistencia'   => new sfWidgetFormTextarea(),
      'textura'        => new sfWidgetFormTextarea(),
      'ojos'           => new sfWidgetFormTextarea(),
      'color'          => new sfWidgetFormTextarea(),
      'sabor'          => new sfWidgetFormTextarea(),
      'humedad'        => new sfWidgetFormTextarea(),
      'materiaGrasa'   => new sfWidgetFormTextarea(),
      'clasificacion'  => new sfWidgetFormTextarea(),
      'coliformes35'   => new sfWidgetFormTextarea(),
      'coliformes45'   => new sfWidgetFormTextarea(),
      'staphilococus'  => new sfWidgetFormTextarea(),
      'salmonella'     => new sfWidgetFormTextarea(),
      'listerya'       => new sfWidgetFormTextarea(),
      'price'          => new sfWidgetFormInputText(),
    ));

    $this->setValidators(array(
      'id'             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'lang'           => new sfValidatorString(array('max_length' => 2)),
      'name'           => new sfValidatorString(array('max_length' => 255)),
      'is_public'      => new sfValidatorBoolean(array('required' => false)),
      'descripcion'    => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'codigo'         => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'premios'        => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'presentaciones' => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'consistencia'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'textura'        => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'ojos'           => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'color'          => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'sabor'          => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'humedad'        => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'materiaGrasa'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'clasificacion'  => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'coliformes35'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'coliformes45'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'staphilococus'  => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'salmonella'     => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'listerya'       => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'price'          => new sfValidatorPass(),
    ));

    $this->widgetSchema->setNameFormat('md_product_search[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProductSearch';
  }

}
