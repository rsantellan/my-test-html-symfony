<?php

/**
 * mdDynamicContentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class mdDynamicContentTable extends PluginmdDynamicContentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object mdDynamicContentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('mdDynamicContent');
    }
}