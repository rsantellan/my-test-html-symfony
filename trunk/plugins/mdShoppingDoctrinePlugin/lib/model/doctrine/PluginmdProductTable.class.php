<?php

abstract class PluginmdProductTable extends Doctrine_Table {


    public function retrieveObject($object_id)
    {
        $query = $this->createQuery('mdP')
                ->where('mdP.id = ?', $object_id);
        return $query->fetchOne();
    }
    public static function getFeatured($category = 0) {

        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u');
        if ($category != 0) {
            $q->leftJoin('u.category c')
                    ->where('c.id = ?', $category);
        }
        $q->where('u.id IN ' . mdFeatureObject::simpleQuery(), 'mdProduct');
        return $q->execute();
    }

    public static function getFeaturedByCategory($category_id, $options = array()) {

        if (!isset($options['isVisible']))
            $options['isVisible'] = 1;


        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u, mdCategoryObject mdC, mdFeatureObject mdFO, mdFeature mdF')
                        ->where('mdFO.md_feature_id = mdF.id')
                        ->addWhere('mdF.object_class_name = ?', 'mdProduct')
                        ->addWhere('u.is_public = ?', $options['isVisible'])
                        ->addWhere('u.id = mdC.object_id')
                        ->addWhere('u.id = mdFO.object_id');


        $listId = array();
        array_push($listId, $category_id);
        $q->whereIn('mdC.md_category_id', $listId);
        if (isset($options['limit']))
            $q->limit($options['limit']);

        return $q->execute();
    }

    public static function getFeaturedByCategoryAndSons($category_id, $options = array()) {

        $sons = doctrine::getTable('mdCategory')->getAllChilds($category_id);


        if (!isset($options['isVisible']))
            $options['isVisible'] = 1;


        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u, mdCategoryObject mdC, mdFeatureObject mdFO, mdFeature mdF')
                        ->where('mdFO.md_feature_id = mdF.id')
                        ->addWhere('mdF.object_class_name = ?', 'mdProduct')
                        ->addWhere('u.is_public = ?', $options['isVisible'])
                        ->addWhere('u.id = mdC.object_id')
                        ->addWhere('u.id = mdFO.object_id');


        $listId = array();
        array_push($listId, $category_id);
        foreach ($sons as $subcat) {
            array_push($listId, $subcat->getId());
        }
        $q->whereIn('mdC.md_category_id', $listId);
        if (isset($options['limit']))
            $q->limit($options['limit']);

        return $q->execute();
    }

    public static function getMdFeatureRelated() {
        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u')
                        ->where('u.id IN (SELECT mdFO.object_id FROM mdFeatureObject mdFO INNER JOIN mdFO.mdFeature mdF WHERE mdF.object_class = ?)', 'mdProduct')
                        ->addWhere('u.md_category_id = ?', '5');

        return $q->execute();
    }

    public function getAllMdProductOfList($idList, $visibility = true) {
        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u');
        if (count($idList) != 0) {
            $q->whereIn('u.id', $idList);
        } else {
            $q->where('u.id = 0');
        }
        if ($visibility) {
            $q->addWhere('u.is_public = ? ', $visibility);
        }

        return $q->execute();
    }

    public static function getPresentationOfCategoryQuery($id = 0, $isVisible = 1) {

        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u, mdCategoryObject mdC')
                        ->addWhere('u.is_public = ?', $isVisible)
                        ->addWhere('u.id = mdC.object_id')
                        ->addWhere('mdC.md_category_id = ?', $id);

        return $q;
    }

    public static function getPresentationOfCategory($id = 0, $isVisible = 1, $isQuery = false) {

        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u, mdCategoryObject mdC')
                        ->addWhere('u.is_public = ?', $isVisible)
                        ->addWhere('u.id = mdC.object_id')
                        ->addWhere('mdC.md_category_id = ?', $id);
        if ($isQuery) {
            return $q;
        }
        return $q->execute();
    }

    public function retrieveAllProductsOfCategory($id = 0, $isVisible = 1, $isQuery = false) {

        $q = Doctrine_Query::create()
                        ->select('u.*')
                        ->from('mdProduct u, mdCategoryObject mdC')
                        ->addWhere('u.is_public = ?', $isVisible)
                        ->addWhere('u.id = mdC.object_id')
                        ->addWhere('mdC.md_category_id = ?', $id);
        $q = $this->addPriorityToQuery($q);
        if ($isQuery) {
            return $q;
        }

        return $q->execute();
    }

    public function retrieveAllProductsIdsOfCategory($id = 0, $isVisible = 1)
    {
        $query = $this->createQuery("u");
        $query->select("u.id")
                    ->addFrom('mdCategoryObject mdC')
                    ->addWhere('u.is_public = ?', $isVisible)
                    ->addWhere('u.id = mdC.object_id')
                    ->addWhere('mdC.md_category_id = ?', $id);
        $query = $this->addPriorityToQuery($query);
        $query->setHydrationMode(Doctrine_Core::HYDRATE_NONE);
        return $query->execute();

    }
    
    public function retrieveAllProductsOfCategories($idList = array(), $isVisible = 1, $isQuery = false) {

        if (count($idList) == 1) {
            return Doctrine::getTable('mdProduct')->retrieveAllProductsOfCategory($idList[0], $isVisible, $isQuery);
        } else {

            $q = Doctrine_Query::create()
                            ->select('u.*')
                            ->from('mdProduct u')
                            ->addWhere('u.is_public = ?', $isVisible);
            foreach ($idList as $id) {
                $q = Doctrine::getTable('mdProduct')->addSortByCategory($q, $id);
            }
            if ($isQuery) {
                return $q;
            }

            return $q->execute();
        }
    }

    public function addSortByCategory($query, $mdCategoryId) {
        $query->addFrom('mdCategoryObject mdC' . $mdCategoryId)
                ->addWhere($query->getRootAlias() . '.id = mdC' . $mdCategoryId . '.object_id')
                ->addWhere('mdC' . $mdCategoryId . '.md_category_id = ?', $mdCategoryId);
        return $query;
    }

    public function retrieveFilterByPriceOfQuery($query, $minimun = 0, $maximun = PHP_INT_MAX, $isQuery = false) {
        $query->addWhere($query->getRootAlias() . '.price >= ?', $minimun);
        $query->addWhere($query->getRootAlias() . '.price <= ?', $maximun);
        if ($isQuery) {
            return $query;
        }

        return $query->execute();
    }

    public function addFilterByMdProfile($query, $profiles, $isQuery = false) {
        if ($query == null) {
            $query = $this->createQuery('n');
        }
        return doctrine::getTable('mdProfileObject')->addJoinWithProfiles($query, $profiles);
    }

    public function retrieveBulkExportData($md_profile_id) {
        return $this->addFilterByMdProfile(null, $md_profile_id)->execute();
    }

    public function addVisibleToQuery($query, $visible)
    {
      $query->addWhere($query->getRootAlias().'.is_public = ? ', $visible);
      return $query;
      
    }

    public function retrieveAllVisibleQuery() {
        $query = $this->createQuery('n');
        $query = $this->addPriorityToQuery($query);
        $query = $this->addVisibleToQuery($query, true);
        return $query;
    }

    public function createQueryForAdmin() {
        $query = $this->createQuery('n');

        $query = $this->addPriorityToQuery($query);
        return $query;
    }

    public function addPriorityToQuery($query) {
      
        if(is_null($query))
        {
          $query = $this->createQuery('n');
        }
      
        if (sfConfig::get('sf_plugins_shopping_sortable', false)) {
            $query->orderBy($query->getRootAlias() . '.priority ASC');
        }
        else
        {
            $query->orderBy($query->getRootAlias() . '.id DESC');
        }
        return $query;
    }

    public function retrieveLastPriorityNumber()
    {
        $query = Doctrine_Query::create ()
                ->select('MAX(d.priority)')
                ->from('mdProduct d');
        return $query->fetchOne(array(), Doctrine_Core::HYDRATE_SCALAR);
    }
    

		/**
		 * Retorna coleccion de productos asociados a una categoria
		 * 
		 * $options permite:
		 * 
		 * $options[query]				doctrine_query		query base
		 * $options[isVisible]		bool							Productos visibles o no
		 * $options[recursive]		bool							Agrega también los asociados con las categorías hijas de la recibida
		 * $options[return_query]	bool							retorna la query sin ejecutar
		 * $options[order_by_product]  bool							ordena la query por la prioridad de los productos
		 * @param string $category_id 
		 * @param string $options 
		 * @return void
		 * @author maui .-
		 */
		
		public function retrieveProductsByCategory($category_id, $options=array()){
			if(isset($options['query']))
				$q = $options['query'];
			else{
				$q = $this->createQuery('p');
				$q->select($q->getRootAlias() . '.*');
			}
			
			if (!isset($options['isVisible']))
          $options['isVisible'] = 1;

      $q->addWhere($q->getRootAlias() . '.is_public = ?', $options['isVisible']);
			
			$parents[] = $category_id;
			
			if(isset($options['recursive'])){
        if($options['recursive'])
        {
          $parent = mdCategoryHandler::retrieveCategory($category_id);
          foreach($parent->getAllSonsCategories() as $cat){
            $parents[] = $cat->getId();
          }
        }
			}
			$q->addFrom('mdCategoryObject co')
				->addWhere($q->getRootAlias() . '.id = co.object_id');
      if(count($parents) == 1)
      {
        $parent = array_shift($parents);
        $q->addWhere('co.md_category_id = ?',$parent);
      }
      else
      {
        $q->whereIn('co.md_category_id',$parents);
      }
			if(isset($options['order_by_product'])){
        if($options['order_by_product'])
        {
          $q = $this->addPriorityToQuery($q);
        }
      }
      else
      {
        $q->orderBy('co.priority ASC');
      }      
			//
      
			if(isset($options['return_query']))
				return $q;
			else
				return $q->execute();
		}
}
