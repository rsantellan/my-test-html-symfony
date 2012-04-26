<?php

/**
 * mdCategory form.
 *
 * @package    plugin mdCategory
 * @subpackage form
 * @author     Gaston Caldeiro
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdCategoryForm extends BasemdCategoryForm
{
    public function setup()
    {
        parent::setup();

        unset($this['label'], $this['updated_at'],$this['created_at'], $this['priority']);

        $this->widgetSchema['object_class_name'] = new sfWidgetFormInputHidden();

        if($this->getObject()->getObjectClassName()){ //Si tiene seteada la clase de los objetos que maneja la categoria

            //si esta configurado para que solo se maneje un nivel de categorias padre
            if(sfConfig::get('sf_plugins_category_mono_level', false))
            {

								//si el objeto del form ya tiene configurado un padre, lo paso como input hidden
								if($this->getObject()->getMdCategoryParentId())
									$parent_hidden_value = $this->getObject()->getMdCategoryParentId();
								else //sino levanto los objetos categoria del nivel 0
                	$objects = Doctrine::getTable('mdCategory')->getRoots($this->getObject()->getObjectClassName());
            }
            else
            {
                if($this->isNew()) //si es un nuevo objeto
                {
										if($this->getObject()->getMdCategoryParentId()){ //si tiene configurado un parent_id pido los hijos de este
                    	$objects = Doctrine::getTable('mdCategory')->findByClassAndParentId($this->getObject()->getObjectClassName(),$this->getObject()->getMdCategoryParentId(),array('recursive'=>true));
										}else{ // sino busco todas los objetos relacionados al tipo object class
											$objects = Doctrine::getTable('mdCategory')->findBy('object_class_name', $this->getObject()->getObjectClassName());
										}
                }
                else //si es edicion
                {
										//excluyo la categoria editada y sus hijos
                    $exclude = $this->getObject()->getAllSonsCategories();
                    array_push($exclude, $this->getObject());
										

										if($this->getObject()->getMdCategoryParentId()){
                    	$objects = Doctrine::getTable('mdCategory')->findByClassAndParentId($this->getObject()->getObjectClassName(),$this->getObject()->getMdCategoryParentId(), array('exclude'=>$exclude,'recursive'=>true));
										}else{
                      $categoriesList = array();
											$objects = Doctrine::getTable('mdCategory')->findByClassNotIn($this->getObject()->getObjectClassName(), $categoriesList);
										}
                }
            }

        }else{

            $objects = Doctrine::getTable('mdCategory')->findAll();

        }
				// si solo tengo un padre disponible lo uso sin dar la opcion de elegirlo.
				if(isset($objects) and count($objects)==1){
					$parent_hidden_value = $objects->getFirst()->getId();
				}
				
				if(isset($parent_hidden_value)){
        	$this->widgetSchema['md_category_parent_id'] = new sfWidgetFormInputHidden(array(), array('value' =>$parent_hidden_value));
				}else{
	        $choices = array(0 => '');
	        foreach($objects as $object){
	            $choices[$object->getId()] = $object->getName();
	        }
	        $this->widgetSchema['md_category_parent_id'] = new sfWidgetFormChoice(array('choices' => $choices));
				}

        $this->embedI18n ( array ( sfContext::getInstance()->getUser()->getCulture()) );

        if( sfConfig::get( 'sf_plugins_category_attributes', false ) )
        {
			
            $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

            $myForm = new sfForm();

            foreach($mdAttributesForms as $tmpForm)
            {
							$myForm->embedForm ( $tmpForm->getName (), $tmpForm );

            }

            $this->embedForm('mdAttributes', $myForm);
        }
    }

    public function configure()
    {
    }
  
    public function save($con = null)
    {
        $tainted = $this->getTaintedValues ();
        if( sfConfig::get( 'sf_plugins_category_attributes', false ) )
        {
            if($this->getObject ()->getEmbedProfile())
            {
                $attributesValues = $tainted ['mdAttributes'];
                unset ( $this ['mdAttributes'], $tainted ['mdAttributes'] );
            }
        }

        $mdCategory = parent::save($con);

        if(!$mdCategory->getLabel())
        {
            $mdCategory->setLabel(mdBasicFunction::slugify($mdCategory->getName()));
            $mdCategory->save();
        }

        if( sfConfig::get( 'sf_plugins_category_attributes', false ) )
        {
            if($this->getObject ()->getEmbedProfile())
            {

                $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

                foreach($mdAttributesForms as $tmpForm)
                {
                    $form_values = $attributesValues[$tmpForm->getName ()];
                    $form_values [$tmpForm->getCSRFFieldName ()] = $tmpForm->getCSRFToken ();
                    $tmpForm->bind ( $form_values );
                    if ($tmpForm->isValid ())
                    {
                        //Al ser valido lo salvo
                        $mdCategory->saveAllAttributes ( $tmpForm );
                    }
                }
            }
        }
        return $mdCategory;
    }

}
