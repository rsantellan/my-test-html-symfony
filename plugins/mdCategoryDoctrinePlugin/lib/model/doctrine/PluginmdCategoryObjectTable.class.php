<?php

/**
 */
class PluginmdCategoryObjectTable extends Doctrine_Table {

    public function addJoinWithCategories($query, $categories, $options = array()) {

        //inicializo las opciones
        if (!isset($options['recursive']))
            $options['recursive'] = false;
        if (!isset($options['excluded']))
            $options['excluded'] = array();


        //soluciono problema de hidratacion
        if ($query->getType() == Doctrine_Query_Abstract::SELECT)
            $query->select($query->getRootAlias() . '.*');

        $query->addFrom('mdCategoryObject mdC')
                ->addWhere($query->getRootAlias() . '.id = mdC.object_id');
        $query->distinct(true);

        if (gettype($categories) != "array") {
            $categories = array($categories);
        }
        $cat_ids = array();
        foreach ($categories as $cat_id) {
            $cat_ids[] = $cat_id;
            if ($options['recursive']) {
                $sons = doctrine::getTable('mdCategory')->getAllChilds($cat_id);
                foreach ($sons as $subcat) {
                    $cat_ids[] = $subcat->getId();
                }
            }
        }
        $query->andWhereIn('mdC.md_category_id', $cat_ids);

        foreach ($options['excluded'] as $cat_id) {
            $query->addWhere('mdC.md_category_id != ?', $cat_id);
            if ($options['recursive']) {
                $sons = doctrine::getTable('mdCategory')->getAllChilds($cat_id);
                foreach ($sons as $subcat) {
                    $query->andWhere('mdC.md_category_id != ?', $subcat->getId());
                }
            }
        }

        return $query;
    }

    public function getAllObjectsFromCategory($mdCategoryId, $limit = 0, $random = false, $sons = false) {
        $query = Doctrine_Query::create ();
        if (!$random) {
            $query->select('mdC.*');
        } else {
            $query->select('mdC.*, RANDOM() AS rand');
        }
        $query->from('mdCategoryObject mdC')
                ->where('mdC.md_category_id = ?', $mdCategoryId);

        if ($sons == true) {
            $cat = doctrine::getTable('mdCategory')->find($mdCategoryId);
            $cat_hijos = $cat->getAllSonsCategories();
            foreach ($cat_hijos as $hijo) {
                $query->orWhere('mdC.md_category_id = ?', $hijo->getId());
            }
        }

        if ($limit != 0) {
            $query->limit($limit);
        }
        if ($random) {
            $query->orderby('rand');
        }else
        {
          $query->orderby('mdC.priority ASC');
        }
        
        if (sfConfig::get('sf_driver_cache')) {
            //$query->useResultCache(true, $time_to_life, 'nk_character_accepted_id_s' . $nkProductionId);
        }
        
        if ($limit == 1) {
            return $query->fetchOne();
        }
        return $query->execute();
    }

    public function retrieveAllFinalObjectFromCategoryAndSons($mdCaetgoryId, $limit = 0, $random = false, $add_sons = true) {
        $objects = $this->getAllObjectsFromCategory($mdCaetgoryId, $limit, $random, $add_sons);
        $out = array();

        foreach ($objects as $obj) {
            $out[] = $obj->retrieveObject();
        }
        return $out;
    }

    public function retrieveAllObjectInfoOfObject($object) {
        $query = Doctrine_Query::create ()
                        ->select('mdCO.*')
                        ->from('mdCategoryObject mdCO, mdCategory mdC')
                        ->where('mdCO.object_id = ?', $object->getId())
                        ->addWhere('mdCO.md_category_id = mdC.id')
                        ->addWhere('mdC.object_class_name = ?', $object->getObjectClass());
        return $query->execute();
    }

    public function retrieveMdCategoryOfMdObject($id, $class) {
        $query = Doctrine_Query::create ()
                        ->select('mdCO.*')
                        ->from('mdCategoryObject mdCO, mdCategory mdC')
                        ->where('mdCO.object_id = ?', $id)
                        ->addWhere('mdCO.md_category_id = mdC.id')
                        ->addWhere('mdC.object_class_name = ?', $class);
        return $query->fetchOne();
    }

    public function retrieveMdCategoryObject($objectId, $mdCategoryId)
    {
      $query = $this->createQuery("mdCO")
                        ->where('mdCO.object_id = ?', $objectId)
                        ->addWhere('mdCO.md_category_id = ?', $mdCategoryId);
      return $query->fetchOne();
    }
}
