<?php

class MdProductHandler
{

		public static function retrieveProductsByCategory($category_id,$options = array()){
			return Doctrine::getTable('mdProduct')->retrieveProductsByCategory($category_id, $options);
		}

    public static function retrieveAllProductsOfMdCategory($mdCategoryId, $isVisible = 1, $isQuery = false)
    {
        return Doctrine::getTable('mdProduct')->retrieveAllProductsOfCategory($mdCategoryId, $isVisible, $isQuery);
        
    }

    public static function retrieveAllProductsOfMdCategoriesList($idList = array(), $isVisible = 1, $isQuery = false)
    {
        return Doctrine::getTable('mdProduct')->retrieveAllProductsOfCategories($idList, $isVisible, $isQuery);
    }

    public static function retrieveFilterByPriceOfQuery($query, $minimun = 0, $maximun = PHP_INT_MAX, $isQuery = false)
    {
        return Doctrine::getTable('mdProduct')->retrieveFilterByPriceOfQuery($query, $minimun, $maximun, $isQuery);
    }

    public static function retrieveAllUsableMdProfile()
    {
        return Doctrine::getTable('mdProfile')->getMdProfilesByObjectClassName('mdProduct');
    }

    public static function retrieveAllMdProductsOfAProfile($profile_name, $isQuery = false)
    {
        $mdProfile = mdProfileHandler::retrieveMdProfileByName($profile_name);
        $list = array();
        array_push($list, $mdProfile->getId());
        $query = Doctrine::getTable('mdProduct')->addFilterByMdProfile(null, $list ,$isQuery );
        if($isQuery)
        {
            return $query;
        }
        return $query->execute();
    }

    public static function addFilterByProfilesToQuery($query, $profiles, $isQuery)
    {
        $query = Doctrine::getTable('mdProduct')->addFilterByMdProfile($query, $profiles ,$isQuery );
        if($isQuery)
        {
            return $query;
        }
        return $query->execute();
    }

    public static function retrieveMdProductById($id)
    {
        return  Doctrine::getTable ( 'mdProduct' )->find ( $id ) ;
    }
}