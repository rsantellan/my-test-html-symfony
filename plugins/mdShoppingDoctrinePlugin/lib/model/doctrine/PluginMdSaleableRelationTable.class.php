<?php

abstract class PluginMdSaleableRelationTable extends Doctrine_Table
{
    public function retrieveFromParentId($parentId){
        $query = Doctrine_Query::create ()
						->select( 'mdS.*' )
						->from ( 'MdSaleableRelation mdS' )
						->where ( 'mdS.md_saleable_parent_id = ?', $parentId);

		return $query->fetchOne();
	}
}