<?php

/**
 * MdSaleable
 *
 * This class has been auto-generated by the Doctrine ORM Framework
 *
 * @package    mdShoppingPlugin
 * @subpackage model
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginMdSaleable extends BaseMdSaleable
{

	private $object = null;

	public function getObject() {
		if ($this->object==null){
			$className = $this->getObjectClass();
			$this->object = Doctrine::getTable($className)->find($this->getObjectId());
		}
		return $this->object;
	}

	public function getmdSaleableParents(){
		$return = array();
		foreach($this->getmdSaleableRelationsRelatedByMdSaleableSonId() as $mdSaleableRelation){
			$return[] = Doctrine::getTable("MdSaleable")->find($mdSaleableRelation->getMdSaleableSonId());
		}
		return $return;
	}

	public function getMdSaleableSons(){
		$return = array();
		foreach($this->getMdSaleableRelation() as $mdSaleableRelation){
			$return[] = Doctrine::getTable("MdSaleable")->find($mdSaleableRelation->getMdSaleableSonId());
		}
		return $return;
	}

	/**
	 * Returns all the mdGainMdSaleables of the mdSaleable item, if it doesn't have any it will populate it with all the mdGain.
	 *
	 * @return array of mdGainMdSaleables
	 */
	public function getAllMdGainMdSaleables(){
		$gains = Doctrine_Core::getTable('MdGain')->retrieveAllMdGain();
		$gainsSaleables = $this->getmdGainMdSaleables();
		if(count($gains) != count($gainsSaleables)){
			foreach($gains as $gain){
				$found = false;
				$index = 0;

				while($index<count($gainsSaleables) && !$found){
					if($gain->getId() == $gainsSaleables[$index]->getMdGainId()){
						$found = true;
					}
					$index++;
				}
				if(!$found){
						$mdGainSaleable = new mdGainMdSaleable();
						$mdGainSaleable->setmdSaleable($this);
						$mdGainSaleable->setmdGain($gain);
						$mdGainSaleable->setGainPercentage($gain->getDefaultPercentage());
						array_push($gainsSaleables,$mdGainSaleable);
				}
			}
		}
		return $gainsSaleables;
	}
}