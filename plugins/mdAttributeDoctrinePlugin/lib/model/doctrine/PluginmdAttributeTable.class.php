<?php

abstract class PluginmdAttributeTable extends Doctrine_Table
{
    /**
     * Gets all the attributes of the given class
     * @param string $class
     * @return Doctrine_Collection
     * @author Rodrigo Santellan
     */
    public function getAllAttributesByClass($class)
    {
        $q = $this->createQuery('c')->where('class = ?',$class);
        return $q->execute();
    }

    public function findAttributes($timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
                ->select ('mdA.id, mdA.name, mdA.translated, mdAT.label')
                ->from('mdAttribute mdA')
                ->innerJoin('mdA.Translation mdAT');

        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_profile_' . $profileId);
        }

        return $query->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    }

    public function findAttributesValues($mdObject, $profileId, $attribute_ids = array(), $culture = 'es', $timeToLife = 86400)
    {
            $query = Doctrine_Query::create()
                ->select ('mdAO.id, mdAO.md_attribute_id, mdAO.md_attribute_value_id, mdAOT.value, mdAO.value_non_translated')
                ->from ('mdAttributeObject mdAO')
                ->leftJoin('mdAO.Translation mdAOT')
                ->addWhere('mdAO.object_id = ?', $mdObject->getId())
                ->addWhere('mdAO.object_class_name = ?', $mdObject->getObjectClass())
                ->addWhere('mdAO.md_profile_id = ?', $profileId)                   
                ->whereIn('md_attribute_id', $attribute_ids);
        
        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $mdObject->getId() . '_class_' . $mdObject->getObjectClass() . '_' . $culture . '_profile_' . $profileId);
        }

        return $query->execute(array(), Doctrine_Core::HYDRATE_ARRAY);
    }

    public function findValue($mdObject, $mdAttributeId, $culture = 'es', $timeToLife = 86400)
    {
        $query = Doctrine_Query::create()
                ->select ('a.id, at.name')
                ->from ('mdAttributeValue a')
                ->innerJoin('a.Translation at')
                ->where('at.lang = ?', $culture)
                ->addWhere('a.id = ?', $mdAttributeId);

        if(sfConfig::get('sf_driver_cache'))
        {
            $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_id_' . $mdObject->getId() . '_class_' . $mdObject->getObjectClass() . '_' . $culture . '_profile_attribute_' . $mdAttributeId;
            $query->useResultCache(true, $timeToLife, $key);
        }

        $a = $query->fetchOne(array(), Doctrine_Core::HYDRATE_SCALAR);
        return $a['at_name'];
    }

    public function refreshCache($objectId, $objectClass)
    {
        sfContext::getInstance()->getLogger()->err(sfConfig::get('sf_driver_cache'));
        if(sfConfig::get('sf_driver_cache'))
        {
            $modes = array(Doctrine_Core::HYDRATE_RECORD, Doctrine_Core::HYDRATE_ARRAY);
            $manager = Doctrine_Manager::getInstance();
            $cacheDriver =  $manager->getAttribute(Doctrine_Core::ATTR_RESULT_CACHE);
            foreach($modes as $hydrationMode)
            {
                $key = sfConfig::get('sf_root_dir');// . '_' . $this->getTableName() . '_id_' . $objectId . '_class_' . $objectClass;
                $cacheDriver->deleteByPrefix($key);
            }
        }
        else
        {
            sfContext::getInstance()->getLogger()->err("!!!!!!!! Falso");
        }
        
    }
}
