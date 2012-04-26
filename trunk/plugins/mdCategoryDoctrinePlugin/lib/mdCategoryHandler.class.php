<?php

class mdCategoryHandler {

    /**
     * Retrieves all parent categories from given class
     * @input className String
     * @output Doctrine_Collection
     *
     * @author Rodrigo Santellan
     * */
    public static function retrieveAllParentCategoriesOfClass($className) {
        return Doctrine::getTable('mdCategory')->getOnlyParents($className);
    }

    public static function retrieveBySlug($slug, $user_culture)
    {
        return Doctrine::getTable('mdCategory')->findOneBySlugAndCulture($slug, $user_culture);
    }
    
    /**
     * Retrieves all objects from given label
     * @input label string
     * @output Doctrine_Collection
     *
     * @author maui
     * */
		public static function retrieveByLabel($label){
			return Doctrine::getTable('mdCategory')->findByLabel($label)->getFirst();
		}
    
    /**
     * Retrieves all objects from given category id
     * @input categoryId Integer
     * @output Doctrine_Collection
     *
     * @author Rodrigo Santellan
     * */
    public static function retrieveAllObjectsFromCategory($categoryId, $page = 1, $limitPager = NULL, $limitQuery = NULL, $random = false, $add_sons = true) {
      return self::retrieveAllObjectsFromCatagory($categoryId, $page, $limitPager, $limitQuery, $random, $add_sons);
    }

    /**
     * Retrieves all objects from given category id
     * @deprecated Esta para eliminarse dado el nombre. Usar retrieveAllObjectsFromCategory con los mismos parametros.
     * @input categoryId Integer
     * @output Doctrine_Collection
     * @author Rodrigo Santellan
     * */
    public static function retrieveAllObjectsFromCatagory($categoryId, $page = 1, $limitPager = NULL, $limitQuery = NULL, $random = false, $add_sons = true) {
        
        $list = Doctrine::getTable('mdCategoryObject')->retrieveAllFinalObjectFromCategoryAndSons($categoryId, $limitQuery, $random, $add_sons);
        
        if ($page == 1 && $limitPager == NULL) {
            return $list;
        } else {
            if ($limitPager == NULL) {
                return $list;
            }
            $array_contents = array_chunk($list, $limitPager);
            if (array_key_exists(($page - 1), $array_contents)) {
                return $array_contents[$page - 1];
            } else {
                return $list;
            }
        }
    }

    /**
     * Retrieves category by given id id
     * @input categoryId Integer
     * @output mdCategory
     *
     * @author Rodrigo Santellan
     * */
    public static function retrieveCategory($id) {
        return Doctrine::getTable('mdCategory')->find($id);
    }

    public static function changePriority($mdCategoryId, $value) {
        $mdCategory = mdCategoryHandler::retrieveCategory($mdCategoryId);
        if ($value == 1) {
            $aux = mdCategoryHandler::retrieveLastPriorityNumber($mdCategory->getObjectClassName(), $mdCategory->getMdCategoryParentId());
            if ($mdCategory->getPriority() == $aux) {
                return $aux;
            }
            $next = $mdCategory->getPriority() + $value;
            $nextObject = Doctrine::getTable('mdCategory')->retrieveByPriorityNumber($next, $mdCategory->getObjectClassName(), $mdCategory->getMdCategoryParentId());
            $nextObject->setPriority($mdCategory->getPriority());
            $nextObject->save();
            $mdCategory->setPriority($next);
            $mdCategory->save();
            return $next;
        } else {
            if ($mdCategory->getPriority() == 1) {
                return 1;
            }
            $next = $mdCategory->getPriority() + $value;
            $nextObject = Doctrine::getTable('mdCategory')->retrieveByPriorityNumber($next, $mdCategory->getObjectClassName(), $mdCategory->getMdCategoryParentId());
            $nextObject->setPriority($mdCategory->getPriority());
            $nextObject->save();
            $mdCategory->setPriority($next);
            $mdCategory->save();
            return $next;
        }
        return $value;
    }

    public static function retrieveLastPriorityNumber($object_class, $mdCategoryParentId = null) {
        $aux = Doctrine::getTable('mdCategory')->retrieveLastPriorityNumber($object_class, $mdCategoryParentId);
        return $aux['mdC_MAX'];
    }

    public static function retrieveCategoryOfObject($mdObject) {
        try
        {
            $mdCategoryObject = Doctrine::getTable('mdCategoryObject')->retrieveMdCategoryOfMdObject($mdObject->getId(), $mdObject->getObjectClass());
            if($mdCategoryObject)
                return $mdCategoryObject->getMdCategory();
            return NULL;
        }catch(Exception $e)
        {
            sfContext::getInstance()->getLogger()->err($e->getMessage());
            return NULL;
        }
        
    }

    public static function addCategoryToObject($mdObject, $mdCategory) {
        $mdCategoryObject = new mdCategoryObject();
        $mdCategoryObject->setObjectClassName($mdObject->getObjectClass());
        $mdCategoryObject->setObjectId($mdObject->getId());
        $mdCategoryObject->setMdCategoryId($mdCategory->getId());
        $mdCategoryObject->save();
    }

    public static function addCategoryToObjectWithIds($md_object_id, $md_category_id) {
        /*echo $md_category_id;
        echo "\n---------------------------------------------------------\n";
        $mdCategory = self::retrieveCategory($md_category_id);
        if($mdCategory)
        {
          echo "existe";
        }
        else
        {
          echo "no existe";
        }
        echo "\n---------------------------------------------------------\n";
        * 
        return false;*/
        $aux = $md_category_id;
        $mdCategoryObject = new mdCategoryObject();
        $mdCategoryObject->setMdCategoryId($md_category_id);
        $mdCategoryObject->setObjectId($md_object_id);
        try {
            $mdCategoryObject->save();
        } catch (Exception $e) {
            //No se loguea por los tasks
            //sfContext::getInstance()->getLogger()->info($e->getMessage());
            
        }
        $mdCategory = self::retrieveCategory($md_category_id);
        if(!is_null($mdCategory->getMdCategory()->getId()))
        {
          self::addCategoryToObjectWithIds($md_object_id, $mdCategory->getMdCategory()->getId());
        }
        
        return $mdCategoryObject;
    }

    public static function retrieveAllMdCategorySons($id) {
        $list = Doctrine::getTable('mdCategory')->getChilds($id);
        return $list;
    }

    public static function retrieveAllMdCategoryOfObject($object_class, $object_id) {

        $list = Doctrine::getTable('mdCategory')->getByObject($object_class, $object_id);
        return $list;
    }

    public static function retrieveAllMdCategorySonsByLabel($label) {
        $mdCategory = Doctrine::getTable('mdCategory')->retrieveMdCategoryByLabel($label);
        return self::retrieveAllMdCategorySons($mdCategory->getId());
    }

    public static function retrieveAllOptionOfFilter($object_class, $type = null)
    {
      
      $found = false;
      if( sfConfig::get( 'sf_plugins_categories_separate_by_type', false ) )
      {
        $parentCategories = array();
        $categoryProfileDisplay = sfConfig::get( 'app_plugins_category_by_elements', null );
        if(!is_null($categoryProfileDisplay))
        {
          foreach($categoryProfileDisplay as $categoryProfile)
          {
            if($categoryProfile['object_class'] == $object_class)
            {
                if($categoryProfile['object_type'] == $type)
                {
                    array_push($parentCategories, mdCategoryHandler::retrieveCategory($categoryProfile['category_root_id']));
                    $found = true;
                }
            }
          }
          if($found == true)
          {
            $values = array();
            $data = array();
            $data[] = '';

            foreach ($parentCategories as $key => $choice)
            {
                $childs = Doctrine::getTable('mdCategory')->getChilds($choice['id']);

                foreach($childs as $k => $val){
                    $values[$val->getId()] = $val->__toString();
                }
                
                $data[$choice->__toString()] = $values;
                $values = array();
            }
            return $data;            
          }
        }
      }
      if($found == false)
      {
          return array('0'=> '');
      }   
      return Doctrine::getTable('mdCategory')->getChoices('mdDynamicContent');   
      
    }
}
