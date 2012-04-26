<?php

class mdAttributeWidgetTextInputPassword extends mdAttribute implements iMdAttribute{

	private $value = null;
	
	public function getWidget(){
		return new sfWidgetFormInputPassword();
	}
	
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
			$requiered = true;	
		}
		//new sfValidatorPass();
		return new sfValidatorPass(array('required'=>$requiered));
		
	}
	
	public function setParentAttributes($parent){
		$this->setId($parent->getId());
		$this->setName($parent->getName());
		$this->setLabel($parent->getLabel());
		$this->setRequiered($parent->getRequiered());
		$this->setTypeClass($parent->getTypeClass());
    $this->setTranslated($parent->getTranslated());
	}
	
	public function setValue($value){
		$this->value = $value;
	}
	
	public function isMultiple(){
		return false;
	}
	
	public function isValueDependent(){
		return false;
	}
	
	public function setMyMdAttributeValueId($id){
		//Abstract
	}

    public function isDateWidget() {
        return false;
    }

    public function isCheckBox(){
        return false;
    }
}
