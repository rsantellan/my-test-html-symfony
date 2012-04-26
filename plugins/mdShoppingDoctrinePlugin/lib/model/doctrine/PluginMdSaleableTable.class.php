<?php

abstract class PluginMdSaleableTable extends Doctrine_Table
{
    /**
	 * retreive an mdSaleable object from an object that implements mdSaleableBehavior
	 *
	 * @param mdSaleableBehavior $object
	 * @return mdSaleable
	 * @author Rodrigo Santellan
	 */
	public function retreiveByObject($object){

            $query = $this->createQuery("mdS")
                            ->where ( 'mdS.object_id = ?', $object->getId () )
                            ->addWhere ( 'mdS.object_class = ?', $object->getObjectClass () );
            return $query->fetchOne ();
	}

}