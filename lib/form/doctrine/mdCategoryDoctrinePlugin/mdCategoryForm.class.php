<?php

/**
 * mdCategory form.
 *
 * @package    naturalia
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdCategoryForm extends PluginmdCategoryForm {

    public function configure() {

        if ($this->getObject()->getObjectClassName()) { //Si tiene seteada la clase de los objetos que maneja la categoria
            //si esta configurado para que solo se maneje un nivel de categorias padre
            if (sfConfig::get('sf_plugins_category_mono_level', false)) {
                //si el objeto del form ya tiene configurado un padre, lo paso como input hidden
                if ($this->getObject()->getMdCategoryParentId())
                    $parent_hidden_value = $this->getObject()->getMdCategoryParentId();
                else //sino levanto los objetos categoria del nivel 0
                    $objects = Doctrine::getTable('mdCategory')->getRoots($this->getObject()->getObjectClassName());
            }
            else {
                
                if ($this->isNew()) { //si es un nuevo objeto
                    if ($this->getObject()->getMdCategoryParentId()) { //si tiene configurado un parent_id pido los hijos de este
                        $objects = Doctrine::getTable('mdCategory')->findByClassAndParentId($this->getObject()->getObjectClassName(), $this->getObject()->getMdCategoryParentId(), array('recursive' => true));
                    } else { // sino busco todas los objetos relacionados al tipo object class
                        $objects = Doctrine::getTable('mdCategory')->findBy('object_class_name', $this->getObject()->getObjectClassName());
                    }
                } else { //si es edicion
                    //excluyo la categoria editada y sus hijos
                    $exclude = $this->getObject()->getAllSonsCategories();
                    array_push($exclude, $this->getObject());


                    if ($this->getObject()->getMdCategoryParentId()) {
                        $objects = Doctrine::getTable('mdCategory')->findByClassAndParentId($this->getObject()->getObjectClassName(), $this->getObject()->getMdCategoryParentId(), array('exclude' => $exclude, 'recursive' => true));
                    } else {
                        $categoriesList = array();
                        $objects = Doctrine::getTable('mdCategory')->findByClassNotIn($this->getObject()->getObjectClassName(), $categoriesList);
                    }
                }
            }
        } else {

            $objects = Doctrine::getTable('mdCategory')->findAll();
        }
        // si solo tengo un padre disponible lo uso sin dar la opcion de elegirlo.
        /*
        if (isset($objects) and count($objects) == 1) {
            $parent_hidden_value = $objects->getFirst()->getId();
        }
        */
        if (isset($parent_hidden_value)) {
            $this->widgetSchema['md_category_parent_id'] = new sfWidgetFormInputHidden(array(), array('value' => $parent_hidden_value));
        } else {
            $choices = array(null => null);
            foreach ($objects as $object) {
                $choices[$object->getId()] = $object->getName();
            }
            $this->widgetSchema['md_category_parent_id'] = new sfWidgetFormChoice(array('choices' => $choices));
        }
    }
}

    
