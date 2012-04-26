<?php

class mdAttributeWidgetDateSfExtraPicker extends mdAttribute implements iMdAttribute{

	private $value = null;
	
	public function getWidget(){
		if($this->value != null){
      //die($this->value);
			return new sfExtraWidgetFormInputDatepicker(array('default' => date($this->value)));
		}
    $default = date('Y - m - d');
		return new sfExtraWidgetFormInputDatepicker(array('default' => $default));
	}
	
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
       return new sfValidatorDate(array('required' => true));	
		}
		return new sfValidatorDate();
		
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
        return true;
    }

    public function isCheckBox(){
        return false;
    }
}
