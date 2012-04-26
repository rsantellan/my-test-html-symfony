<?php

class mdAttributeWidgetTinyEditorTextAreaActive extends mdAttributeWidgetTinyEditorTextArea
{
  public function getWidget(){
      $this->showTiny = true;
      return parent::getWidget();
  }
}
