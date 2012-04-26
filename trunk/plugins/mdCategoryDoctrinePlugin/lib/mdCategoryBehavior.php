<?php

/**
 *
 *
 * @author     maui
 */

class mdCategoryBehavior extends Doctrine_Template
{

    public function setTableDefinition()
    {
        $this->addListener(new mdCategoryBehaviorListener());
    }

    public function getObjectClass(){
    	return get_class($this->getInvoker());
    }

    public function getmdCategoryTree(){
        
        return Doctrine::getTable('mdCategory')->getTreeByObject($this->getInvoker()->getObjectClass(), $this->getInvoker()->getId());
    }
    public function getmdCategories(){
        return mdCategoryHandler::retrieveAllMdCategoryOfObject($this->getInvoker()->getObjectClass(), $this->getInvoker()->getId());
        
    }
   
    public function hasCategory($mdCategoryId = 0, $orParent = true){
    	$list = $this->getmdCategories();
    	foreach($list as $cat){
    		if($cat->getId() == $mdCategoryId){
    			return true;
    		}
    		if($orParent){
    			$aux = $cat;
    			if($aux->getMdCategory()->getMdCategoryParentId()){
    				//print_r('aaa');
    			}
    			$end = false;
    			while(!$end){
    				$aux = $aux->getMdCategory();
    				if($aux->getId() == $mdCategoryId){
    					return true;
    				}
    				if($aux->getMdCategoryParentId()){
    					$aux = $aux->getMdCategory();
    				}else{
    					$end = true;
    				}
    			}
    		}
    	}
    	return false;
    }
}
