<?php

/**
 * mdDynamicContent filter form.
 *
 * @package    aeromarket
 * @subpackage filter
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdDynamicContentFormFilter extends BasemdDynamicContentFormFilter {

    public function configure() {

    }

    public function setup() {
        parent::setup();
        
        unset($this['updated_at'], $this['created_at'], $this['publish_at'], $this['publish_up_to']);

        $this->widgetSchema['md_word'] = new sfWidgetFormInput();
        $this->validatorSchema['md_word'] = new sfValidatorString(array('required' => false));

        $this->widgetSchema['type_name'] = new sfWidgetFormInputHidden();
        $this->validatorSchema['type_name'] = new sfValidatorString(array('required' => false));
        
        /*
          $this->widgetSchema['publish_at'] = new sfExtraWidgetFormInputDatepicker(array('default' => date('Y-m-d')));

          $this->validatorSchema['publish_at'] = new sfValidatorDateTime();

          $this->widgetSchema['publish_up_to'] = new sfExtraWidgetFormInputDatepicker(array('default' => date('Y-m-d')));

          $this->validatorSchema['publish_up_to'] = new sfValidatorDateTime();

         */
        if (sfConfig::get('sf_plugins_dynamic_category', false)) {
            $type = $this->getDefaults();
            $type = $type[0];
            $choices = mdCategoryHandler::retrieveAllOptionOfFilter('mdDynamicContent', $type);
            $this->widgetSchema['md_category_id'] = new sfWidgetFormChoice(array(
                        'choices' => $choices,
                    ));
        }

        if (sfConfig::get('sf_plugins_dynamic_category', false)) {
            $this->validatorSchema['md_category_id'] = new sfValidatorInteger();
        }
    }

    public function addTypeNameColumnQuery(Doctrine_Query $query, $field, $values){
      if($values != ''){
        $query = Doctrine::getTable('mdDynamicContent')->addTypeName($query, $values);
      }
    }

    public function addMdWordColumnQuery(Doctrine_Query $query, $field, $values)
    {
        if($values != ''){
            $type_name = parent::getValue('type_name');
            $send_type_name = NULL;
            if($type_name != '')
            {
                $send_type_name = $type_name;
            }
            $lang = 'es';
            $query = mdDynamicContentHandler::searchContents($values, $send_type_name, true, false, $lang, $query);
        }
    }
    public function addMdCategoryIdColumnQuery(Doctrine_Query $query, $field, $values) {

        if ($values != '0') {
            $query = Doctrine::getTable('mdCategoryObject')->addJoinWithCategories($query, $values);
        }
    }


    public function getFields() {
        $add_category_field = array_merge(parent::getFields(), array('md_category_id' => 'Number'));
        $add_category_field = array_merge($add_category_field, array('md_word'=> 'Text'));
        return array_merge($add_category_field, array('text_value' => 'Text'));
    }

}
