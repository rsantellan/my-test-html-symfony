<?php

class mdDynamicContentHandler{

    public static function retrieveAllMdDynamicContentOfType($type_name, $onlyVisible = false, $limit = null)
    {
        return Doctrine::getTable('mdDynamicContent')->retrieveCollection($type_name, $onlyVisible, $limit);
    }

    public static function retrieveAllMdDynamicContentOfTypeQuery($type_name, $onlyVisible = false, $limit = null)
    {
        return Doctrine::getTable('mdDynamicContent')->retrieveCollectionQuery($type_name, $onlyVisible, $limit);
    }
    
    public static function retrieveMdDynamicById($id, $isVisible = true)
    {
        return Doctrine::getTable('mdDynamicContent')->retrieveOneById($id, $isVisible);
    }

    public static function retrieveAllMdDynamicsOfMdCategory($mdCategoryId, $isQuery = false, $query = null)
    {
        return Doctrine::getTable('mdDynamicContent')->retrieveAllMdDynamicsOfCategory($mdCategoryId, $isQuery, $query);
    }

    public static function retrieveAllMdDynamicsOfFeature($id = 0, $isQuery = false, $limit = null, $orderByFeature = false) 
    {
        return Doctrine::getTable('mdDynamicContent')->retrieveAllMdDynamicsOfFeature($id, $isQuery, $limit, $orderByFeature);
    }
    
    public static function retrieveAllMdDynamicObjectsOfIdList($idList, $isQuery = false, $isVisible = true)
    {
        if(count($idList) == 0)
        {
            if($isQuery)
            {
                return self::retrieveEmptyQuery();
            }
            else
            {
                return self::retrieveEmptyQuery()->execute();
            }
        }
        $query = Doctrine::getTable('mdDynamicContent')->retrieveAllInList($idList, null, $isVisible);
        if($isQuery)
        {
            return $query;
        }
        return $query->execute();
    }

    private static function retrieveEmptyQuery()
    {
        return Doctrine_Query::create()
                        ->select('mdC.*')
                        ->from('mdDynamicContent mdC')
                        ->where('mdC.id < 0');
    }
    public static function searchContents($word, $type = NULL, $is_query = true, $onlyVisible = false, $lang = "es", $query = NULL)
    {
        $list = mdAttributeHandler::searchContents($word, "mdDynamicContent", $lang);
        if(count($list) == 0)
        {
            if($is_query)
            {
                if($query != NULL)
                {
                    return $query;
                }
                return self::retrieveEmptyQuery();
            }
            else
            {
                return self::retrieveEmptyQuery()->execute();
            }
        }
        $query = Doctrine::getTable('mdDynamicContent')->searchContents($list, $type, $onlyVisible, $query);
        if($is_query)
        {
            return $query;
        }
        else
        {
            return $query->execute();
        }
    }
}
