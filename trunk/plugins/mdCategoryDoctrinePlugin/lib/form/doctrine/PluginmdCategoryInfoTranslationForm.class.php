<?php

/**
 * PluginmdCategoryInfoTranslation form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdCategoryInfoTranslationForm extends BasemdCategoryInfoTranslationForm
{
  public function setup()
  {
     parent::setup();
     $this->widgetSchema['description'] = new sfWidgetFormTextareaTinyMCE(array(
            'width' => 578,
            'height' => 400,
            'config' => 'plugins : "pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,contextmenu,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,wordcount,advlist,autosave",
                        theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,formatselect,|,search,replace,|,bullist,numlist,|,outdent,indent,|,undo,redo",
                        theme_advanced_buttons2 : "link,unlink,code,|,insertdate,inserttime,preview,|,forecolor,backcolor,|fullscreen,|,cut,copy,paste,pastetext,pasteword",
                        theme_advanced_buttons3 : "",
                        theme_advanced_buttons4 : ""'
        ));;
  }

}
