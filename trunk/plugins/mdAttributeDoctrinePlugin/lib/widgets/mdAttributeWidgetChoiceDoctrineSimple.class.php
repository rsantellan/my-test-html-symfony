<?php

class mdAttributeWidgetChoiceDoctrineSimple extends mdAttribute implements iMdAttribute {

    private $value = null;
    private $attValueId = null;

    public function getWidget() {
        $class = $this->getChoiceValues();
        if ($this->attValueId != null) {
            return new sfWidgetFormDoctrineChoice(array('model' => $class, 'add_empty' => false, 'default' => $this->attValueId, 'label' => $this->getLabel()));
            $value = "";
            $widget = new sfWidgetFormChoice(array('choices' => $values, 'default' => $this->attValueId, 'label' => $this->getLabel()));
            $widget->setDefault($this->attValueId);

            return $widget;
        }
        return new sfWidgetFormDoctrineChoice(array('model' => $class, 'add_empty' => false, 'label' => $this->getLabel()));
    }

    private function getChoiceValues() {
        $values = $this->getAllMdAttributeValuesForChoice();
        return array_pop($values);
    }

    public function getValidator() {
        $requiered = false;
        if ($this->getRequiered()) {
            $requiered = true;
        }
        return new sfValidatorDoctrineChoice(array('model' => $this->getChoiceValues(), 'column' => 'id', 'required' => false));
        //$values = $this->getChoiceValues();
        //return new sfValidatorChoice(array('choices' => array_keys($values), 'required' => $requiered));
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
        $this->value = $value;
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

    public function isCheckBox() {
        return false;
    }

}
