<?php

/**
 * MdSaleableTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class MdSaleableTable extends PluginMdSaleableTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object MdSaleableTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('MdSaleable');
    }
}