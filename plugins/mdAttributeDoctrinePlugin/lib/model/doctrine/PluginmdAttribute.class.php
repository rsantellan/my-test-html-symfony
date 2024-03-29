<?php

/**
 * mdAttribute
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    mdAttributePlugin
 * @subpackage model
 * @author     Your name here
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginmdAttribute extends BasemdAttribute
{

    public function returnLogicClass(){
        return new $this->getTypeClass();
    }

    public function getInstance(){
        $typeClass = $this->getTypeClass();
        $class = new $typeClass;
        $class->setParentAttributes($this);
        return $class;
    }

    public function getAllMdAttributeValues(){
        return Doctrine::getTable('mdAttributeValue')->getValuesOfAttribute($this->getId());
    }

    public function getAllMdAttributeValuesForChoice(){
        $list = array();

        foreach(Doctrine::getTable('mdAttributeValue')->getValuesOfAttribute($this->getId()) as $value){
                $list[$value->getId()] = $value->getName();
        }
        return $list;
    }

    public function getClass(){
        return 'mdAttribute';
    }
}
