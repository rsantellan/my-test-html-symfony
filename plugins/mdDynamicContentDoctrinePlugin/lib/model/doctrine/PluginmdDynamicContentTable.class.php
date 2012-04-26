<?php

abstract class PluginmdDynamicContentTable extends Doctrine_Table
{

    public function retrieveObject($object_id, $timeToLife = 86400, $hydrationMode = Doctrine_Core::HYDRATE_RECORD)
    {
        //Creamos la Doctrine Query
        $query = Doctrine_Query::create()
                ->select('mdD.*')
                ->from('mdDynamicContent mdD')
                ->where('mdD.id = ?', $object_id);

        //Seteamos modo de hidratacion
        $query = $query->setHydrationMode($hydrationMode);

        //Cacheamos el resultado
        if(sfConfig::get('sf_driver_cache') && Md_Cache::$_use_cache)
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $object_id . '_' . $hydrationMode);
        }

        return $query->fetchOne();
    }

    public function retrieveOneById($object_id, $onlyVisible = false)
    {
        $query = $this->createQuery('mdD')
                    ->addWhere("mdD.id = ?", $object_id);
        
        if($onlyVisible)
        {
            $query = $this->onlyVisible($query);
        }
        return $query->fetchOne();
    }

    public function retrieveCollectionQueryOfCategoryFilterByTypeName($mdCategoryId, $typeName, $equal = true, $order = "ASC")
    {
      
      $query = $this->createQuery('mdD')
                ->select('mdD.*')
                ->addFrom('mdCategoryObject m')
                ->addFrom('mdCategory m1');
      if($equal)
      {
        $query->where('mdD.type_name = ?', $typeName);
      }
      else
      {
        $query->where('mdD.type_name <> ?', $typeName);
      }
      $query->addWhere('m.object_id = mdD.id')
            ->addWhere('m1.id = m.md_category_id')
            ->addWhere('m1.object_class_name = "mdDynamicContent"')
            ->addWhere('m1.id = ?', $mdCategoryId)
            ->orderBy('m.priority '.$order);
      return $query;
    }
  
    public function retrieveCollectionQuery($typeName = NULL, $onlyVisible = false, $limit = null)
    {
        $query = $this->createQuery('mdD');
        if(!is_null($typeName))
        {
            $query->addWhere('mdD.type_name = ?', $typeName);
        }
        if($onlyVisible)
        {
            $query = $this->onlyVisible($query);
        }
        
        if( sfConfig::get( 'sf_plugins_dynamic_priority', false ) )
        {
          $query->orderBy('mdD.priority ASC');
        }
        else
        {
            $query->orderBy('mdD.id DESC');
        }
        if(!is_null($limit))
        {
            $query->limit($limit);
        }
        return $query;
    }

    private function onlyVisible($query)
    {
        if( sfConfig::get( 'sf_plugins_dynamic_show_is_visible', false ) )
        {

            $query->addWhere($query->getRootAlias().'.is_public = ?', true);
        }
        if( sfConfig::get( 'sf_plugins_dynamic_show_publish_at', false ) )
        {
            $query = $this->addOnDate($query);
        }
        return $query;
    }
    
    public function retrieveCollection($typeName = NULL, $onlyVisible = false, $limit = null)
    {
        $query = $this->retrieveCollectionQuery($typeName, $onlyVisible, $limit);
        if($limit == 1)
        {
            return $query->fetchOne();
        }
        return $query->execute();
    }

    public function addOnDate($query = null, $date = null)
    {
        if($query == null)
        {
            $query = $this->createQuery('mdD');
        }
        if($date == null)
        {
            $date = date('Y-m-d H:i:s');
        }
        $query->addWhere($query->getRootAlias().'.publish_at <= ?', $date);
        $query->addWhere($query->getRootAlias().'.publish_up_to >= ?', $date);
        return $query;
    }
    
    public function retrieveAllOnDateObjects($date, $listIn = array())
    {
        $query = $this->createQuery('mdD')
            ->where('mdD.publish_at <= ?', $date)
            ->addWhere('mdD.publish_up_to >= ?', $date);
        if(count($listIn) > 0)
        {
            $query = $this->retrieveAllInList($listIn, $query);//$query->andWhereIn('n.id', $listIn);
        }
        return $query->execute();
    }

    public function searchContents($listIn, $type = NULL, $isVisible = true, $query = null)
    {
        if(is_null($type))
        {
            return $this->retrieveAllInList($listIn, $query, $isVisible);
        }
        else
        {
//            if($query == null)
//            {
//                $query = $this->createQuery('mdD');
//            }
            $query = $this->addTypeName($query, $type);
            
            return $this->retrieveAllInList($listIn, $query, $isVisible);
        }
    }

    public function addTypeName($query = null, $type = NULL){
        if($query == null){
            $query = $this->createQuery('mdD');
        }
        if($type != NULL)
        {
            $query->addWhere($query->getRootAlias().'.type_name = ?', $type);
        }
        return $query;
    }
    
    public function retrieveAllInList($listIn, $query = null, $isVisible = true)
    {
        if($query == null){
            $query = $this->createQuery('n');
        }
        $query->andWhereIn($query->getRootAlias().'.id', $listIn);
        if($isVisible)
        {
            $query = $this->onlyVisible($query);
        }
        return $query;
    }
    
    public function retrieveAllRelatedDynamicOfCertainParent($mdParentId, $type, $query = false)
    {
        $q = $this->createQuery('n')
            ->select('n.*')
            ->addFrom('mdContent c')
            ->addFrom('mdContentRelation mr')
            ->where('n.type_name = ?', $type)
            ->addWhere('n.id = c.object_id')
            ->addWhere('c.object_class = "mdDynamicContent"')
            ->addWhere('c.id = mr.md_content_id_second')
            ->addWhere('mr.md_content_id_first = ?', $mdParentId);
        //print_r($q->getSqlQuery());
        if($query)
        {
            return $q;
        }
        return $q->execute();
    }
    public function retrieveAllOnDateObjectsOfCategory($date,  $list = array() )
    {
        $query = $this->createQuery('n')
            ->select('n.*')
            ->addFrom('mdCategoryObject m')
            ->addFrom('mdCategory m1')
            ->where('n.publish_at <= ?', $date)
            ->addWhere('n.publish_up_to >= ?', $date)
            ->addWhere('m.object_id = n.id')
            ->addWhere('m1.id = m.md_category_id')
            ->addWhere('m1.object_class_name = "mdDynamicContent"')
            ->andWhereIn('m.md_category_id' , $list);
        return $query->execute();
    }

    public function retrieveFirstPriorityObject($object_type)
    {
        $query = $this->createQuery('n')
                ->select('n.*')
                ->orderBy('n.priority ASC')
                ->limit(1);
        $query->fetchOne();
    }

    public function retrieveLastPriorityNumber($object_type)
    {
        $query = Doctrine_Query::create ()
                ->select('MAX(d.priority)')
                ->from('mdDynamicContent d')
                ->where('d.type_name = ?',$object_type);
        return $query->fetchOne(array(), Doctrine_Core::HYDRATE_SCALAR);
    }

    public function retrieveByPriorityNumber($priority, $object_type)
    {
        $query = Doctrine_Query::create ()
                ->select('mdC.*')
                ->from('mdDynamicContent mdC')
                ->where('mdC.type_name = ?',$object_type)
                ->addWhere('mdC.priority = ?', $priority);
        return $query->fetchOne();
    }
        
    public function refreshCache($objectId)
    {
        if(sfConfig::get('sf_driver_cache'))
        {
            $modes = array(Doctrine_Core::HYDRATE_RECORD, Doctrine_Core::HYDRATE_ARRAY);

            $manager = Doctrine_Manager::getInstance();
            $cacheDriver = $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);

            foreach($modes as $hydrationMode)
            {
                $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $objectId  . '_' . $hydrationMode;
                $cacheDriver->delete($key);
            }
        }
    }
    
    public function addFilterByMdProfile($query, $profiles, $isQuery = false)
    {
        if($query == null){
            $query = $this->createQuery('n');
        }
        return doctrine::getTable('mdProfileObject')->addJoinWithProfiles($query, $profiles);
    }

    public function retrieveBulkExportData($md_profile_id)
    {
        return $this->addFilterByMdProfile(null, $md_profile_id)->execute();
    }


    public function retrieveAllMdDynamicsOfCategory($id = 0, $isQuery = false, $query = null) 
    {
      if(is_null($query))
      {
        $query = $this->createQuery('mdD');
      }
      $query->select($query->getRootAlias().".*");
      $query->addFrom('mdCategoryObject mdC')
            ->addWhere($query->getRootAlias().'.id = mdC.object_id')
            ->addWhere('mdC.md_category_id = ?', $id);
        if( sfConfig::get( 'sf_plugins_dynamic_priority', false ) )
        {
          $query->orderBy('mdC.priority ASC');
        }
        if ($isQuery) {
            return $query;
        }

        return $query->execute();
    }
    
    public function retrieveAllMdDynamicsOfFeature($id = 0, $isQuery = false, $limit = null, $orderByFeature = false) 
    {
        $query = $this->createQuery('u')->select('u.*');
        $query->addFrom('mdFeatureObject mdF')
              ->addWhere('u.id = mdF.object_id')
              ->addWhere('mdF.md_feature_id = ?', $id);
        if($orderByFeature)
        {
          $query->orderBy('mdF.id DESC');
        }
        if(!is_null($limit))
        {
          $query->limit($limit);
        }
        if ($isQuery) {
            return $query;
        }
        $query = $this->onlyVisible($query);
        return $query->execute();
    }
}
