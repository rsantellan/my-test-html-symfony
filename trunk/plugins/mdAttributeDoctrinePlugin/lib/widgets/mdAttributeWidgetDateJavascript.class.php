<?php

class mdAttributeWidgetDateJavascript extends mdAttribute implements iMdAttribute {

    private $value = null;
    private $attValueId = null;
    
    public function getWidget() {
        if(sfConfig::get( 'app_use_prototype', false ))
        {

        }
        if(is_null($this->value))
        {
            $this->value = array("date" => date("Y-m-d"));
        }
        else
        {
            $this->value = array("date" => $this->value);
        }
        
        return new sfWidgetFormInputDatepicker(array('value' =>$this->value));
    }

    public function getValidator() {
        $requiered = false;
        if ($this->getRequiered()) {
            $requiered = true;
        }

        return new sfValidatorDate(array('required' => $requiered));
    }

    public function setParentAttributes($parent) {
        $this->setId($parent->getId());
        $this->setName($parent->getName());
        $this->setLabel($parent->getLabel());
        $this->setRequiered($parent->getRequiered());
        $this->setTypeClass($parent->getTypeClass());
        $this->setTranslated($parent->getTranslated());
    }

    public function setValue($value) {
        /*if(is_array($value))
        {
            $value = implode( "-" ,$value);
        }*/
        //print_r($value);
        $this->value = $value;
        //print_r($value);
        /*$dateArray = explode(" - ", $value);
        //print_r($dateArray);
        $valueDateArray = array();
        $valueDateArray['year'] = $dateArray[0];
        $valueDateArray['month'] = $dateArray[1];
        $valueDateArray['day'] = $dateArray[2];
        $culture;
        if (sfContext::hasInstance ()) {
            $culture = sfContext::getInstance ()->getUser()->getCulture();
        } else {
            $culture = sfConfig::get('sf_default_culture');
        }
        $this->value = $valueDateArray; // date("M-d-Y", mktime(0, 0, 0, 12, $dateArray[0], 1997));
         * 
         */
    }

    public function isMultiple() {
        return false;
    }

    public function isValueDependent() {
        return false;
    }

    public function setMyMdAttributeValueId($id) {
        $this->attValueId = $id;
    }

    public function isDateWidget() {
        return false;
    }

    public function isCheckBox(){
        return false;
    }

}
