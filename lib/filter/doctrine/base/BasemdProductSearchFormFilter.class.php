<?php

/**
 * mdProductSearch filter form base class.
 *
 * @package    naturalia
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasemdProductSearchFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_public'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'descripcion'    => new sfWidgetFormFilterInput(),
      'premios'        => new sfWidgetFormFilterInput(),
      'presentaciones' => new sfWidgetFormFilterInput(),
      'consistencia'   => new sfWidgetFormFilterInput(),
      'textura'        => new sfWidgetFormFilterInput(),
      'ojos'           => new sfWidgetFormFilterInput(),
      'color'          => new sfWidgetFormFilterInput(),
      'sabor'          => new sfWidgetFormFilterInput(),
      'humedad'        => new sfWidgetFormFilterInput(),
      'materiaGrasa'   => new sfWidgetFormFilterInput(),
      'clasificacion'  => new sfWidgetFormFilterInput(),
      'coliformes35'   => new sfWidgetFormFilterInput(),
      'coliformes45'   => new sfWidgetFormFilterInput(),
      'staphilococus'  => new sfWidgetFormFilterInput(),
      'salmonella'     => new sfWidgetFormFilterInput(),
      'listerya'       => new sfWidgetFormFilterInput(),
      'price'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'           => new sfValidatorPass(array('required' => false)),
      'is_public'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'descripcion'    => new sfValidatorPass(array('required' => false)),
      'premios'        => new sfValidatorPass(array('required' => false)),
      'presentaciones' => new sfValidatorPass(array('required' => false)),
      'consistencia'   => new sfValidatorPass(array('required' => false)),
      'textura'        => new sfValidatorPass(array('required' => false)),
      'ojos'           => new sfValidatorPass(array('required' => false)),
      'color'          => new sfValidatorPass(array('required' => false)),
      'sabor'          => new sfValidatorPass(array('required' => false)),
      'humedad'        => new sfValidatorPass(array('required' => false)),
      'materiaGrasa'   => new sfValidatorPass(array('required' => false)),
      'clasificacion'  => new sfValidatorPass(array('required' => false)),
      'coliformes35'   => new sfValidatorPass(array('required' => false)),
      'coliformes45'   => new sfValidatorPass(array('required' => false)),
      'staphilococus'  => new sfValidatorPass(array('required' => false)),
      'salmonella'     => new sfValidatorPass(array('required' => false)),
      'listerya'       => new sfValidatorPass(array('required' => false)),
      'price'          => new sfValidatorPass(array('required' => false)),
    ));

    $this->widgetSchema->setNameFormat('md_product_search_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'mdProductSearch';
  }

  public function getFields()
  {
    return array(
      'id'             => 'Number',
      'lang'           => 'Text',
      'name'           => 'Text',
      'is_public'      => 'Boolean',
      'descripcion'    => 'Text',
      'premios'        => 'Text',
      'presentaciones' => 'Text',
      'consistencia'   => 'Text',
      'textura'        => 'Text',
      'ojos'           => 'Text',
      'color'          => 'Text',
      'sabor'          => 'Text',
      'humedad'        => 'Text',
      'materiaGrasa'   => 'Text',
      'clasificacion'  => 'Text',
      'coliformes35'   => 'Text',
      'coliformes45'   => 'Text',
      'staphilococus'  => 'Text',
      'salmonella'     => 'Text',
      'listerya'       => 'Text',
      'price'          => 'Text',
    );
  }
}
