<?php

abstract class PluginmdUnitConvertionTable extends Doctrine_Table
{
	public function getRatio($from,$to){
		$query = Doctrine_Query::create ()
						->select ( 'mdUC.*' )
						->from ( 'mdUnitConvertion mdUC' )
						->where ( 'from_unit = ?', $from )
						->addWhere('to_unit = ?', $to );

			return $query->fetchOne();
	}
}