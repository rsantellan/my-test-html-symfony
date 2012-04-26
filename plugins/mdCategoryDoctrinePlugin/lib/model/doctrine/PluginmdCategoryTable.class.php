<?php

abstract class PluginmdCategoryTable extends Doctrine_Table
{
	
  public function getFirstMdCategory()
  {
    $q = $this->createQuery('c');
    $q->limit(1);
    $q->orderby('id ASC');
    return $q->fetchOne();
  }
  
  public function findByClassNotIn($objectClassName, $list = array(), $return_query = false)
  {
    $q = $this->createQuery('c')
        ->where('c.object_class_name = ?',$objectClassName);
    foreach($list as $obj)
    {
        $q->addWhere('c.id != ?', $obj->getId());
    }
		if($return_query) 
			return $q;
		else
    	return $q->execute();
  }

/**
 * Retorna objetos mdCategory con el $objectClassName ,hijas del $parent_id
 * 
 * En $options contempla las siguientes posibilidades
 * $options[exclude] = array()						Array de category_id excluidos de los resultados
 * $options[recursive] = false						Agrega a todos los hijos del $parent_id como posibles padres.
 * $options[return_query] = false					Retorna la doctrine_query
 *
 * @param string $objectClassName 
 * @param string $parent_id 
 * @param string $options 
 * @return void
 * @author maui .-
 */

	public function findByClassAndParentId($objectClassName, $parent_id, $options = array()){

		if(isset($options['exclude']) and $options['exclude']==true)
			$exclude = $options['exclude'];
		else
			$exclude = array();
		
		$q = $this->findByClassNotIn($objectClassName,$exclude,true);

		$parentIds = array();
		$parentIds[]=$parent_id;
		if(isset($options['recursive']) and $options['recursive']==true){
			foreach($this->getAllChilds($parent_id) as $child){
				$parentIds[] = $child->getId();
			}
		}
		$q->whereIn('c.md_category_parent_id', $parentIds);
		$q->orWhere('c.id = ?',$parent_id);
		

		if(isset($options['return_query']) and $options['return_query']==true)
			return $q;
		else
			return $q->execute();

	}

  
    public function findOneBySlugAndCulture($slug, $culture = null)
    {
        if($culture == null) $culture = sfConfig::get('sf_default_culture');//sfConfig::get('sf_default_culture');

        $q = $this->createQuery('c')
            ->leftJoin('c.Translation t')
            ->andWhere('t.lang = ?', $culture)
            ->andWhere('t.slug = ?', $slug);
        return $q->fetchOne();
    }
	
    public function getChilds($id, $culture = null, $timeToLife = 86400){
        
        if($culture == null) $culture = sfConfig::get('sf_default_culture');
        

        $q = $this->createQuery('j')
            ->where('j.md_category_parent_id = ?', $id);
            
        if( sfConfig::get( 'sf_plugins_category_priority', false ) )
        {
          $q->orderBy('j.priority');
        }
        else
        {
            $q->orderBy('j.id ASC');
        }
        if(sfConfig::get('sf_driver_cache'))
        {
            $q->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $id . '_class_mdCategory_');
        }
        return $q->execute();
        return $q->execute(array(), Doctrine_Core::HYDRATE_SCALAR);

    }

    public function getChildsQuery($id){
        $q = $this->createQuery('j')
            ->where('j.md_category_parent_id = ?', $id);
        if( sfConfig::get( 'sf_plugins_category_priority', false ) )
        {
          $q->orderBy('j.priority');
        }            
        return $q;
    }
    
    public function getChildsRandom($id, $limit = 0){
        $q = $this->createQuery('j')
            ->select('j.*, RANDOM() AS rand')
            ->where('j.md_category_parent_id = ?', $id);
        if($limit != 0){
            $q->limit($limit);
        }
        if($limit == 1){
            return $q->fetchOne();
        }
        return $q->execute();
    }

    public function getChildsByLabel($label){
        $cat = $this->findOneByLabel($label);
        if($cat){
            return $this->getChilds($cat->getId());
        }
        return $cat;
    }
	
    public function retrieveMdCategoryByLabel($label)
    {
      $q = $this->createQuery('j')
            ->where('j.label = ?', $label);
            
      return $q->fetchOne();
    }
    public function getOnlyParentsRandomExceptOne($id, $class, $limit = 0){
        $q = $this->createQuery('j')
            ->select('j.*, RANDOM() AS rand')
            ->where('j.md_category_parent_id is null')
            ->addWhere('j.id != ?',$id)
            ->andWhere('j.object_class_name = ?',$class)
            ->orderby('rand');
        if($limit != 0){
            $q->limit($limit);
        }
        return $q->execute();
    }
 
    public function getOnlyParents($class){
        $q = $this->createQuery('j')
            ->where('j.md_category_parent_id is null')
            ->andWhere('j.object_class_name = ?',$class);
        if( sfConfig::get( 'sf_plugins_category_priority', false ) )
        {
          $q->orderBy('j.priority');
        }
        return $q->execute();
    }

    public function getAllChilds($id){
        $out = array();
        foreach($this->getChilds($id) as $child){
            //$child = mdCategory::hydratateMdCategory($child);
            $out[] = $child;
            $grandChilds = $this->getAllChilds($child->getId());
            if($grandChilds){
                foreach($grandChilds as $gChild){
                    array_push($out, $gChild);
                }
            }
        }
        return $out;
    }
				
    public function getByObjectInstance($object){
        return $this->getByObject($object->getObjectClass(), $object->getId());
    }

    public function getByObject($object_class, $object_id,$culture = null, $timeToLife = 86400){
        
        if($culture == null) $culture = sfConfig::get('sf_default_culture');
        
        $q = $query = Doctrine_Query::create ()
              ->select('j.*')
              ->from('mdCategory j, mdCategoryObject o')
              ->where('j.object_class_name = ?', $object_class)
              ->addWhere('o.object_id = ?',$object_id)
              ->addWhere('o.md_category_id = j.id');
/*
        $q = $this->createQuery('j')
            ->addFrom('mdCategoryObject o')
            ->where('j.object_class_name = ?', $object_class)
            ->addWhere('o.object_id = ?',$object_id)
            ->addWhere('o.md_category_id = j.id');
*/
        if( sfConfig::get( 'sf_plugins_category_priority', false ) )
        {
          $q->orderBy('j.priority');
        }
        if(sfConfig::get('sf_driver_cache'))
        {
            $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $object_id . '_class_mdCategory_'.$object_class.'retrieve_all_by_object';

            $q->useResultCache(true, $timeToLife, $key);
        }
        return $q->execute();
        
        //return $q->execute(array(), Doctrine_Core::HYDRATE_SCALAR);
        
    }

    public function getTreeByObjectInstance($object){
        return $this->getTreeByObject($object->getObjectClass(), $object->getId());
    }

    public function getTreeByObject($object_class, $object_id){
        $list = array();
        $tree = null;
        $aux = new mdTreeMdCategory();

        foreach($this->getByObject($object_class, $object_id) as $mdCategory){
            //$mdCategory = mdCategory::hydratateMdCategory($mdCategory);
            if(is_null($tree)){
                $tree = new mdTreeMdCategory($mdCategory->obtainRoot());
            }
            $aux->insert($mdCategory, $tree);
        }
        //$tree->show();
        return $tree;
    }

    public function getLastDescendant(){
        $q = $this->createQuery('c')
                ->where('c.id not in (select distinct md_category_parent_id from md_category m where md_category_parent_id is not null)');
        return $q;
    }

    public function getChoices($objClass){
        $q = $this->getOnlyParents($objClass);
        $values = array();
        $data = array();
        $data[] = '';

        foreach ($q as $key => $choice)
        {
            $childs = $this->getChilds($choice['id']);

            foreach($childs as $k => $val){
                //$val = mdCategory::hydratateMdCategory($val);
                $values[$val['id']] = $val->__toString();
            }
            
            $data[$choice->__toString()] = $values;
            $values = array();
        }

        return $data;
    }

    public function getAllChoices($objClass){
        $q = $this->getOnlyParents($objClass);
        $values = array();
        $data = array();
        $data[] = '';

        foreach ($q as $key => $choice)
        {
            $data = $this->retrieveChildsArray($choice->getId(), $data);
            $data[$choice->getId()] = $choice->__toString();
            $values = array();
        }
        return $data;
    }

    private function retrieveChildsArray($id, $data)
    {
        $childs = $this->getChilds($id);

        foreach($childs as $k => $val){
            $data[$val->getId()] = $val->getName();
            $data = $this->retrieveChildsArray($val->getId(), $data);
        }

        return $data;
    }

    public function getRoots($object_class_name = NULL)
    {
        $q = $this->createQuery('j')
                ->where('j.md_category_parent_id is null');
        if(!is_null($object_class_name)){
            $q->addWhere('j.object_class_name = ?', $object_class_name);
        }
        if( sfConfig::get( 'sf_plugins_category_priority', false ) )
        {
          $q->orderBy('j.priority');
        }
        return $q->execute();
    }
    
    public function retrieveMdCategoriesNotIn($listIds) {
        $query = Doctrine_Query::create ()
            ->select('mdC.*')
            ->from('mdCategory mdC')
            ->whereNotIn('mdC.id', $listIds);

        return $query->execute();
    }
    
    public function retrieveLastPriorityNumber($object_class, $mdCategoryParentId = null)
    {
        $query = Doctrine_Query::create ()
                ->select('MAX(mdC.priority)')
                ->from('mdCategory mdC')
                ->where('mdC.object_class_name = ?',$object_class);

        if(is_null($mdCategoryParentId))
        {
          $query->addWhere('mdC.md_category_parent_id is null');
        }
        else
        {
          $query->addWhere('mdC.md_category_parent_id = ?', $mdCategoryParentId);
        }
        return $query->fetchOne(array(), Doctrine_Core::HYDRATE_SCALAR);
    }

    public function retrieveByPriorityNumber($priority, $object_class, $mdCategoryParentId = null)
    {
        $query = Doctrine_Query::create ()
                ->select('mdC.*')
                ->from('mdCategory mdC')
                ->where('mdC.object_class_name = ?',$object_class)
                ->addWhere('mdC.priority = ?', $priority);

        if(is_null($mdCategoryParentId))
        {
          $query->addWhere('mdC.md_category_parent_id is null');
        }
        else
        {
          $query->addWhere('mdC.md_category_parent_id = ?', $mdCategoryParentId);
        }
        return $query->fetchOne();
    }

    public function retrieveCategoryByLabel($label, $culture = null,  $timeToLife = 86400)
    {
      if($culture == null) $culture = sfConfig::get('sf_default_culture');
        

        $q = $this->createQuery('j')
            ->select('j.*, mdC.name')
            ->addFrom('mdCategoryTranslation mdC')
            ->where('j.id = mdC.id')
            ->addWhere('mdC.lang = ?', $culture)
            ->addWhere('j.label = ?', $label);
        if(sfConfig::get('sf_driver_cache'))
        {
            $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_label_' . $label;

            $q->useResultCache(true, $timeToLife, $key);
        }
       
        return $q->fetchOne(array(), Doctrine_Core::HYDRATE_SCALAR);                  
    }

    public function retrieveCategoryBy($key, $value, $fetch_one = true, $hidrationMode = Doctrine_Core::HYDRATE_RECORD, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
            ->select('c.*')
            ->from('mdCategory c')
            ->where('c.' . $key .' = ?', $value);

        //Seteamos modo de hidratacion ARRAY
        $query->setHydrationMode($hidrationMode);

        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_key_' . $key . 'value_' . $value . '_' . $hidrationMode);
        }
        
        if($fetch_one) return $query->fetchOne();
        else return $query->execute();
    }
    
    public function refreshCache($objectId, $label = null)
    {
        if(sfConfig::get('sf_driver_cache'))
        {
            $modes = array(Doctrine_Core::HYDRATE_RECORD, Doctrine_Core::HYDRATE_ARRAY);

            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);

            foreach($modes as $hydrationMode)
            {
                $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $objectId  . '_class_mdCategory_';
                $cacheDriver->delete($key);
            }
            if(!is_null($label))
            {
              $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_label_' . $label;
              $cacheDriver->delete($key);
            }
        }
    }
    
    
    public function refreshCacheByObject($object_id, $object_class)
    {
      
        if(sfConfig::get('sf_driver_cache'))
        {
            $modes = array(Doctrine_Core::HYDRATE_RECORD, Doctrine_Core::HYDRATE_ARRAY);

            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);

            $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $object_id . '_class_mdCategory_'.$object_class;

            $cacheDriver->deleteByPrefix($key);
        }      
    }
}
