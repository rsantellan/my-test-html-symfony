<?php

interface iMdAttribute {
	
	public function getWidget();
	public function getValidator();
	public function setParentAttributes($parent);
	public function setValue($value);
	public function isMultiple();
	public function isValueDependent();
	public function setMyMdAttributeValueId($id);
    public function isDateWidget();
    public function isCheckBox();
	//protected function saveAtt($conn);
}
