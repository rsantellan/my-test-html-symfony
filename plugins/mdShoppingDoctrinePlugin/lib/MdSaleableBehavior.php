<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MdSaleableBehavior
 *
 * @author pablo
 */
class MdSaleableBehavior extends Doctrine_Template {
    public function setTableDefinition()
    {
            $this->addListener(new MdSaleableBehaviorListener());
    }

    public function getRelatedSaleable(){
    	$object = $this->getInvoker();

    }

    public function getObjectClass(){
    	return get_class($this->getInvoker());
    }
    
}