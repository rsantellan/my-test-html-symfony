<?php

/**
 */
class PluginmdProfileObjectTable extends Doctrine_Table {

    public function findByMultiples($keys = array(), $values = array(), $fetchOne = false, $timeToLife = 86400) {
        $query = Doctrine_Query::create ()
                        ->select('mdPO.*')
                        ->from('mdProfileObject mdPO');

        for ($i = 0; $i < count($keys); $i++) {
            $query->addWhere('mdPO.' . $keys[$i] . ' = ?', $values[$i]);
        }

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . implode('_', $keys) . '_' . implode('_', $values));
        }

        if ($fetchOne) {
            return $query->fetchOne();
        } else {
            return $query->execute();
        }
    }

    public function findByObjectAndMdProfile($object, $mdProfileId, $timeToLife = 86400) {
        $query = Doctrine_Query::create ()
                        ->select('mdPO.*')
                        ->from('mdProfileObject mdPO')
                        ->where('mdPO.md_profile_id = ?', $mdProfileId)
                        ->addWhere('mdPO.object_id = ?', $object->getId())
                        ->addWhere('mdPO.object_class_name = ?', $object->getObjectClass());

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdProfileId . '_' . $object->getId() . '_' . $object->getObjectClass());
        }

        return $query->fetchOne();
    }

    public function findAllObjectIdsByMdProfile($object, $mdProfileId, $timeToLife = 86400) {
        $query = Doctrine_Query::create ()
                        ->select('mdPO.object_id')
                        ->from('mdProfileObject mdPO')
                        ->where('mdPO.md_profile_id = ?', $mdProfileId)
                        ->addWhere('mdPO.object_class_name = ?', $object->getObjectClass());

        if (sfConfig::get('sf_driver_cache')) {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_' . $mdProfileId . '_' . $object->getObjectClass());
        }

        return $query->execute(array(), Doctrine_Core::HYDRATE_SINGLE_SCALAR);
    }

    public function addJoinWithProfiles($query, $profiles, $options = array()) {

        //inicializo las opciones
        if (!isset($options['excluded']))
            $options['excluded'] = array();


        //soluciono problema de hidratacion
        if ($query->getType() == Doctrine_Query_Abstract::SELECT)
            $query->select($query->getRootAlias() . '.*');

        $query->addFrom('mdProfileObject mdPO')
                ->addWhere($query->getRootAlias() . '.id = mdPO.object_id');
        $query->distinct(true);

        if (gettype($profiles) != "array") {
            $profiles = array($profiles);
        }
        $cat_ids = array();
        foreach ($profiles as $cat_id) {
            $cat_ids[] = $cat_id;
        }
        $query->andWhereIn('mdPO.md_profile_id', $cat_ids);

        foreach ($options['excluded'] as $cat_id) {
            $query->addWhere('mdPO.md_profile_id != ?', $cat_id);
        }
        return $query;
    }

}
