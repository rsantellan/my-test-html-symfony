<?php

/**
 * mdContentTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class mdContentTable extends PluginmdContentTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object mdContentTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('mdContent');
    }
}