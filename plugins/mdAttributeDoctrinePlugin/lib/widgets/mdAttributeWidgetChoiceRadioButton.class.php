<?php

class mdAttributeWidgetChoiceRadioButton extends mdAttribute implements iMdAttribute {

    private $value = null;
    private $attValueId = null;

    public function getWidget() {
        $values = $this->getAllMdAttributeValuesForChoice();

        if ($this->attValueId != null) {
            $value = Doctrine::getTable('mdAttributeValue')->find($this->attValueId);
            $widget = new sfWidgetFormChoice(array('choices' => $values, 'default' => $this->attValueId, 'label' => $this->getLabel()));
            $widget->setDefault($this->attValueId);
            return $widget;
        }
        return new sfWidgetFormSelectRadio(array('choices' => $values, 'label' => $this->getLabel()));
    }

    public function getValidator() {
        $requiered = 'false';
        if ($this->getRequiered()) {
            $requiered = 'true';
        }
        $values = $this->getAllMdAttributeValuesForChoice();
        return new sfValidatorChoice(array('choices' => array_keys($values), 'required' => $requiered));
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
        return true;
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
