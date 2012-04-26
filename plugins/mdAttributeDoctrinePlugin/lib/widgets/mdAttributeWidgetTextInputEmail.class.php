<?php

class mdAttributeWidgetTextInputEmail extends mdAttribute implements iMdAttribute{

	private $value = null;
	
	public function getWidget(){
		if($this->value != null){
			return new sfWidgetFormInputConfigurable(array('value'=>$this->value));
		}
		return new sfWidgetFormInputConfigurable();
	}
	
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
			$requiered = true;	
		}
		return new sfValidatorEmail(array('required'=>$requiered));//new sfValidatorString(array('max_length' => 255,'required'=>$requiered));
		
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
