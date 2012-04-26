<?php

class mdAttributeWidgetTinyEditorTextArea extends mdAttribute implements iMdAttribute{

	private $value = null;
  
  protected $showTiny = null;
  
	public function getWidget(){
		if($this->value != null){
                    return new sfWidgetFormTinyEditorTextAreaConfigurable(array(
                            'showTiny'=> $this->showTiny,
                            'label'=>$this->getLabel(),
                            'value'=>$this->value,
                            'width' => 400,
                            'height' => 400,
                            'config' => 'plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist, spellchecker, jfilebrowser",
                                      theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|",
                                      theme_advanced_buttons2 : "bullist,numlist,|,link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|fullscreen,|,cut,copy,paste,pastetext,pasteword,|",
                                      theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid",
                                      theme_advanced_buttons4 : ""'
                        ));
			//return new sfWidgetFormTextAreaConfigurable(array('value'=>$this->value));
		}

		return new sfWidgetFormTinyEditorTextAreaConfigurable(array(
                    'showTiny'=> $this->showTiny,
                    'label'=>$this->getLabel(),
                    'width' => 400,
                    'height' => 400,
                    'config' => 'plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist, spellchecker, jfilebrowser",
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,|,formatselect,fontselect,fontsizeselect,|",
                        theme_advanced_buttons2 : "bullist,numlist,|,link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|fullscreen,|,cut,copy,paste,pastetext,pasteword,|",
                        theme_advanced_buttons3 : "tablecontrols,|,hr,removeformat,visualaid",
                        theme_advanced_buttons4 : ""'
                ));
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
