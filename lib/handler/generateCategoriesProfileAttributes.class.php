<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of generateCategoriesProfileAttributes
 *
 * @author rodrigo
 */
class generateCategoriesProfileAttributes {

  public static function run()
  {
    $profile = Doctrine::getTable('mdProfile')->find(4);
    $attributes = $profile->getMdProfileAttribute();
    
    $categories = Doctrine::getTable('mdCategory')->findAll();
    foreach($categories as $category)
    {
      $keys = array('object_id', 'object_class_name', 'md_attribute_id', 'md_profile_id');
      foreach($attributes as $attribute)
      {
        $values = array($category->getId(), $category->getObjectClass(), $attribute->getMdAttributeId(), 4);
        $attributeObject = Doctrine::getTable('mdAttributeObject')->findByMultiples($keys, $values, true);
        if(!$attributeObject)
        {
          $mdAttributeObject = new mdAttributeObject();
          $mdAttributeObject->setObjectId($category->getId());
          $mdAttributeObject->setObjectClassName($category->getObjectClass());
          $mdAttributeObject->setMdAttributeId($attribute->getMdAttributeId());
          $mdAttributeObject->setMdProfileId(4);
          $mdAttributeObject->setValue(" ");
          $mdAttributeObject->save();
          
          $mdProfileObject = new mdProfileObject();
          $mdProfileObject->setObjectId($category->getId());
          $mdProfileObject->setObjectClassName($category->getObjectClass());
          $mdProfileObject->setMdProfileId(4);
          $mdProfileObject->setActive(true);
          $mdProfileObject->save();
          
          echo 'bip bip ...';
          echo '<hr/>';
        }
      }
      
      //echo $category->getId();
    }
  }
}


