<?php

/**
 * mdCategoryObjectTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class mdCategoryObjectTable extends PluginmdCategoryObjectTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object mdCategoryObjectTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('mdCategoryObject');
    }
}