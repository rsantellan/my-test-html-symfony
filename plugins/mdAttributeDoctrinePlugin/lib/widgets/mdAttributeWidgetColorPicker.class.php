<?php

class mdAttributeWidgetColorPicker extends mdAttribute implements iMdAttribute{

	private $value = null;
	
	public function getWidget(){
		if($this->value != null){
			return new mdWidgetFormInputColorPicker(array('value'=>$this->value));
		}
		return new mdWidgetFormInputColorPicker();
	}
	
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
			$requiered = true;
            return new sfValidatorString(array('required'=>true));
		}
		return new sfValidatorString(array('required'=>false));
		
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
	
	public function getClass(){
		return parent::getClass();
	}

  public function isDateWidget() {
      return false;
  }

  public function isCheckBox(){
      return false;
  }
}
