<?php

class mdAttributeWidgetChoiceSimple extends mdAttribute implements iMdAttribute{

	private $value = null;
	private $attValueId = null;
	
  public function getWidget(){
    $values = $this->getChoiceValues();
    if($this->attValueId != null){

      $value = "";
      $widget = new sfWidgetFormChoice(array('choices'=>$values,'default' => $this->attValueId, 'label'=>$this->getLabel() ));
      $widget->setDefault($this->attValueId);

      return $widget;

    }

    return new sfWidgetFormChoice(array('choices'=>$values, 'label'=>$this->getLabel()));
  }
	
    private function getChoiceValues(){
        $values = $this->getAllMdAttributeValuesForChoice();
        $list = array();
        $list["-"] = "";
        //array_push($list, "");
        foreach($values as $key => $val){
          $list[$key] = $val;
        }
        return $list;
    }

  private function getChoiceValuesValidator()
  {
        $values = $this->getAllMdAttributeValuesForChoice();
        $list = array();
        $list["-"] = "";
        //array_push($list, "");
        foreach($values as $key => $val){
          $list[$key] = $val;
        }
        return $list;    
  }
	public function getValidator(){
		$requiered = false;
		if($this->getRequiered()){
			$requiered = true;	
		}
		$values = $this->getChoiceValuesValidator();
		return new sfValidatorChoice(array('choices' => array_keys($values),'required'=>$requiered));
		
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
		return true;
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
