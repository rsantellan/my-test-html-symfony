<?php

/**
 * mdProduct filter form.
 *
 * @package    mdShoppingPlugin
 * @subpackage filter
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdProductFormFilter extends BasemdProductFormFilter
{
  public function setup()
  {
      parent::setup();
      sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
      $this->widgetSchema['price'] = new mdWidgetFormInputRange(array(
        'from_value' => new sfWidgetFormInput(),
        'to_value'   => new sfWidgetFormInput(),
        'template'  => __("mdProduct_desde").' %from_value% '.__("mdProduct_hasta").' %to_value%',
      ));

      $this->widgetSchema['md_name'] = new sfWidgetFormInput(array(), array('class' => 'input_large'));

      $this->widgetSchema['quantity'] = new mdWidgetFormInputRange(array(
        'from_value' => new sfWidgetFormInput(),
        'to_value'   => new sfWidgetFormInput(),
        'template'  => __("mdProduct_desde").' %from_value% '.__("mdProduct_hasta").' %to_value%',
      ));
      
      $this->widgetSchema['is_public'] = new sfWidgetFormChoice(array(
          'expanded' => true,
          'choices'  => array('2' => __("mdProduct_no importa"), '1' => __("mdProduct_si"), '0' => __("mdProduct_no")),
      ));
      $this->setDefault('is_public','2');
      $choices = Doctrine::getTable('mdCategory')->getAllChoices('mdProduct');

      $this->widgetSchema['md_category_id'] = new sfWidgetFormChoiceAutocompleteComboBox(array(
          'choices' => $choices,
      ));

      $this->validatorSchema['md_name'] = new sfValidatorString(array('required' => false));
      $this->validatorSchema['is_public'] =  new sfValidatorPass();

    if( sfConfig::get( 'sf_plugins_shopping_category', false ) ){
        $this->validatorSchema['md_category_id'] = new sfValidatorInteger();
    }
    if( sfConfig::get( 'sf_plugins_shopping_feature', false ) ){
        $this->validatorSchema['md_features_id'] = new sfValidatorInteger();
    }

      //$currencies = Doctrine::getTable('mdCategory')->getAll();
      $this->widgetSchema['md_currency_id']->setLabel('Currency');
      $this->widgetSchema['md_unit_id']->setLabel('Unit');
      $this->widgetSchema['md_category_id']->setLabel('Category');
      $this->widgetSchema['md_name']->setLabel('Name');

      $this->widgetSchema->setFormFormatterName('list');
  }

  public function addPriceColumnQuery(Doctrine_Query $query, $field, $values){
    if($values['from'] != ''){
        $query->andWhere($field . '>= ?', $values['from']);
    }
    if($values['to'] != ''){
        $query->andWhere($field . ' <= ?', $values['to']);
    }
  }

  public function addQuantityColumnQuery(Doctrine_Query $query, $field, $values){
    if($values['from'] != ''){
      $query->andWhere($field . ' >= ?', $values['from']);
    }

    if($values['to'] != ''){
        $query->andWhere($field . ' <= ?', $values['to']);
    }
  }

  public function addIsPublicColumnQuery(Doctrine_Query $query, $field, $values){
    if(isset($values) && $values[0] != '2')
    {

      if(isset($values) && $values[0] == '1'){
        $query->andWhere($field .' = ?', $values);
      }
      else
      {
        $query->andWhere($field .' = ?', 0);
      }
      
    }

  }

  public function addMdCategoryIdColumnQuery(Doctrine_Query $query, $field, $values){
    if($values != 0){
				$childs = mdCategoryHandler::retrieveAllMdCategorySons($values);
				$ids = array();
				foreach($childs as $cat){
					$ids[] = $cat->getId();
				}
				$subq = 'select object_id from md_category_object where md_category_id=' . $values;
				foreach($ids as $id){
					$subq .= ' or md_category_id = ' . $id;		
				}

        $query->andWhere('id in ('.$subq.')');
    }
  }

  public function addMdNameColumnQuery(Doctrine_Query $query, $field, $values){
    if($values != ''){
        $query->innerJoin($query->getRootAlias() . '.Translation t')
			->addWhere('t.name like \'%' . $values . '%\'');
    }
  }

  public function getFields(){
        $fields = array_merge(parent::getFields(), array('md_name' => 'text'));
        return array_merge($fields, array('md_category_id' => 'number'));
  }

}
