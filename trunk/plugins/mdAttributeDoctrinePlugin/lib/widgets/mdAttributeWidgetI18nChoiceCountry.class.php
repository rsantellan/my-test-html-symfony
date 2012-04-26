<?php

class mdAttributeWidgetI18nChoiceCountry extends mdAttribute implements iMdAttribute{

	private $value = null;
	private $attValueId = null;
	
	public function getWidget(){
		
		if (sfContext::hasInstance ()) {
			return new sfWidgetFormI18nChoiceCountry ( array ('culture' => sfContext::getInstance ()->getUser ()->getCulture () ) );
		} else {
			return new sfWidgetFormI18nChoiceCountry ( );
		}
		
	}
	
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
			$requiered = true;	
		}
		
		return new sfValidatorString(array('max_length' => 2, 'required' => $requiered));
		
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
		$this->attValueId = $id;
	}

    public function isDateWidget() {
        return false;
    }

    public function isCheckBox(){
        return false;
    }
}
