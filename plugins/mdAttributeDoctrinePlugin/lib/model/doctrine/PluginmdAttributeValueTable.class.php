<?php

abstract class PluginmdAttributeValueTable extends Doctrine_Table
{
	/**
	 * Gets all the values of an attribute
	 * @param int $id
	 * @return Doctrine_Collection
	 * @author Rodrigo Santellan
	 */
	public function getValuesOfAttribute($id){
		$query = Doctrine_Query::create ()
						->select ( 'mdAV.*' )
						->from ( 'mdAttributeValue mdAV' )
						->where ( 'mdAV.md_attribute_id = ?', $id );
						
		return $query->execute ();
	}
}
