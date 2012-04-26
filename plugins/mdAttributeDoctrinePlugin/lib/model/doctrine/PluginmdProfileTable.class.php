<?php
/**
 */
class PluginmdProfileTable extends Doctrine_Table
{

    /**
     *
     * @author Rodrigo Santellan
     **/
    public function getMdProfilesByObjectClassName($object_class_name, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create ()
            ->select ( 'mdP.*' )
            ->from ( 'mdProfile mdP' )
            ->where('mdP.object_class_name = ?', $object_class_name);

        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_md_profile_by_class'.$object_class_name);
        }

        return $query->execute();
    }
  
    public function retrieveAllMdProfilesNotBelongingToObject($object_id, $object_class_name, $timeToLife = 86400)
    {
        $query = $this->createQuery("mdP")
                  ->select("mdP.*")
                  ->where("mdP.id NOT IN (SELECT m.md_profile_id FROM mdProfileObject m WHERE (m.object_class_name = ? AND m.object_id = ?))", array($object_class_name, $object_id));
        /*$query = Doctrine_Query::create ()
            ->select ( 'mdP.*' )
            ->from ( 'mdProfile mdP, mdProfileObject mdPO' )
            ->where('mdP.object_class_name = ?', $object_class_name)
            ->addWhere('mdPO.md_profile_id = mdP.id')
            ->addWhere('mdPO.object_id <> ?', $object_id);
        */
        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_md_profile_by_class'.$object_class_name);
        }

        return $query->execute();
    }

    public function retrieveById($id, $timeToLife = 86400)
    {
        $query = Doctrine_Query::create ()
            ->select ( 'mdP.*' )
            ->from ( 'mdProfile mdP' )
            ->where('mdP.id = ?', $id);

        if(sfConfig::get('sf_driver_cache'))
        {
            $query->useResultCache(true, $timeToLife, sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_md_profile_'.$id);
        }

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
                $key = sfConfig::get('sf_root_dir') . '_' . $this->getTableName() . '_md_profile_' . $objectId;
                $cacheDriver->delete($key);
            }
        }
    }
}
