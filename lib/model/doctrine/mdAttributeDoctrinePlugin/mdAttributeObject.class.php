<?php

/**
 * mdAttributeObject
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    naturalia
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class mdAttributeObject extends PluginmdAttributeObject
{
    public function postSave($event)
    {
      parent::postSave($event);
      $culture = sfContext::getInstance()->getUser()->getCulture();
      switch($this->getMdAttributeId())
      {
        case 1:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setDescripcion($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 2:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setPremios($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 3:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setPresentaciones($this->getValue());
            $mdProductSearch->save();
          }
          break;          
        case 4:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setConsistencia($this->getValue());
            $mdProductSearch->save();
          }
          break;     
        case 5:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setTextura($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 6:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setOjos($this->getValue());
            $mdProductSearch->save();
          }
          break;          
        case 7:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setColor($this->getValue());
            $mdProductSearch->save();
          }
          break; 
        case 8:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setSabor($this->getValue());
            $mdProductSearch->save();
          }
          break; 
        case 9:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setHumedad($this->getValue());
            $mdProductSearch->save();
          }
          break; 
        case 10:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setMateriaGrasa($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 11:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setClasificacion($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 12:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setColiformes35($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 13:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setColiformes45($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 14:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setStaphilococus($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 15:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setSalmonella($this->getValue());
            $mdProductSearch->save();
          }
          break;
        case 16:
          $mdProductSearch = Doctrine::getTable("mdProductSearch")->retrieveOneByIdAndLang($this->getObjectId(), $culture);
          if($mdProductSearch)
          {
            $mdProductSearch->setListerya($this->getValue());
            $mdProductSearch->save();
          }
          break;                                                                                             
      }
    }
}