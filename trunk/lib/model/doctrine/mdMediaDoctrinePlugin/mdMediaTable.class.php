<?php

/**
 * mdMediaTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class mdMediaTable extends PluginmdMediaTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object mdMediaTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('mdMedia');
    }
}