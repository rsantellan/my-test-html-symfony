<?php

abstract class PluginmdUnitTable extends Doctrine_Table
{
	public function getAllRelatedUnits($mdUnitId){
/*		$q = $this->createQuery('j')
			->where('j.id = ?',$mdUnitId);
		return $q->execute();*/

		$query = Doctrine_Query::create()
					->select('mdU.*')
					->from('mdUnit mdU, mdUnitConvertion mdUC, mdUnitConvertion mdUC1')
					->where('mdU.id = ?',$mdUnitId)
					->orWhere('mdUC.from_unit = ?',$mdUnitId)
					->orWhere('mdUC1.to_unit = ?',$mdUnitId)
					->andWhere('mdUC1.from_unit = mdU.id')
					->andWhere('mdUC.to_unit = mdU.id');
		sfContext::getInstance()->getLogger()->err('<!-------!>');
		sfContext::getInstance()->getLogger()->err($query->getSqlQuery());
		sfContext::getInstance()->getLogger()->err($mdUnitId);
		return $query->execute();
	}

	public function getAllFromUnits($mdUnitId){
		$query = Doctrine_Query::create()
					->select('mdU.*')
					->from('mdUnit mdU, mdUnitConvertion mdUC, mdUnitConvertion mdUC1')
					->where('mdU.id = mdUC.from_unit')
					->orWhere('mdUC.to_unit = ?',$mdUnitId);
		sfContext::getInstance()->getLogger()->err('<!-------!>');
		sfContext::getInstance()->getLogger()->err($query->getSqlQuery());
		sfContext::getInstance()->getLogger()->err($mdUnitId);
		return $query->execute();
	}

  public function getAllUnits(){
    $query = $this->createQuery('j');

    return $query->execute();
  }
}