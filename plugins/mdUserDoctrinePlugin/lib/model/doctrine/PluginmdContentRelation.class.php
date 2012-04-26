<?php

/**
 * PluginmdContentRelation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginmdContentRelation extends BasemdContentRelation
{

    public static function addContent(mdContent $mdContent, mdContent $mdContenToAdd, $profileName)
    {
        $mdContentRelation = new mdContentRelation();
        $mdContentRelation->setMdContentIdFirst($mdContent->getId());
        $mdContentRelation->setMdContentIdSecond($mdContenToAdd->getId());
        $mdContentRelation->setObjectClassName($mdContenToAdd->getObjectClass());
        if(!is_null($profileName))
        {
            $mdContentRelation->setProfileName($profileName);
        }
        $mdContentRelation->save();
        //Eliminarlo del cache
        Doctrine::getTable('mdContentRelation')->refreshCache($mdContent->getId(), $mdContenToAdd->getObjectClass(), $profileName);
        return $mdContentRelation;
    }

    public static function removeContent(mdContent $mdContent, mdContent $mdContenToRemove, $profileName)
    {
        $mdContentRelation = Doctrine::getTable('mdContentRelation')->find(array($mdContent->getId(),$mdContenToRemove->getId()));
        if($mdContentRelation)
        {
            $mdContentRelation->delete();
            //Eliminarlo del cache
            Doctrine::getTable('mdContentRelation')->refreshCache($mdContent->getId(), $mdContenToRemove->getObjectClass(), $profileName);
        }
    }

    public static function retrieveContentRelationIds($mdContentId, $object_class_name = NULL, $profileName = NULL)
    {
        $contentIds = array();
        $contents = Doctrine::getTable('mdContentRelation')->retrieveContentRelationIds($mdContentId, $object_class_name, $profileName);
        foreach ($contents as $dataId)
        {
            $contentIds[] = (int)$dataId[0];
        }
        return $contentIds;
    }

    public static function retrieveContentRelationIdsByChilds($mdContentId, $object_class_name = NULL, $profileName = NULL)
    {
        $contentIds = array();
        $contents = Doctrine::getTable('mdContentRelation')->retrieveContentRelationIdsByChilds($mdContentId, $object_class_name, $profileName);
        foreach ($contents as $dataId)
        {
            $contentIds[] = (int)$dataId[0];
        }
        return $contentIds;
    }

    
    
}
