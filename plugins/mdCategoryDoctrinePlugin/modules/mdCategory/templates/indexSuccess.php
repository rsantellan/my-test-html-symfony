<?php 

slot('mdCategoryAdmin',':D');

use_helper('mdAsset');
use_helper( 'JavascriptBase' );
use_javascript('tiny_mce/tiny_mce.js');

use_plugin_stylesheet('mastodontePlugin', '../js/jquery-ui-1.8.4/css/smoothness/jquery-ui-1.8.4.custom.css');
use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-ui-1.8.4.custom.min.js', 'last');
use_plugin_javascript('mastodontePlugin','jquery-ui-1.8.4/development-bundle/ui/i18n/jquery.ui.datepicker-'.sfContext::getInstance()->getUser()->getCulture().'.js','last');
use_plugin_javascript('mastodontePlugin', 'jType.js');
use_plugin_javascript('mastodontePlugin', 'mastodontePlugin.backendBasic.js');
use_plugin_javascript('mdCategoryDoctrinePlugin', 'mdCategory.js');

if( sfConfig::get( 'sf_plugins_category_attribute_color_picker', false ) ):  
	use_plugin_javascript('mastodontePlugin', 'colorpicker.js');
	use_plugin_stylesheet('mastodontePlugin', 'colorpicker.css'); 
endif;

if( sfConfig::get( 'sf_plugins_category_media', false ) ): 
	include_partial('mdMediaContentAdmin/javascriptInclude');
endif;

?>
<div id="md_center_container">
    <div class="md_shadow">
        <div class="md_center">
            <div class="md_content_center">
                <h1 style="float: left"><?php echo __('mdCategoryDoctrine_text_title'); ?></h1>
                <div class="clear"></div>
                
                <?php /** LINK AGREGAR NUEVO PRODUCTO **/ ?>
                <div id="md_content_actions">
                    <a id="addBox" href="<?php echo url_for('mdCategory/showCategoryForm?categoryId='.$mdCategories[0]->getId());?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().addBox(); return false;"><?php echo __('mdCategoryDoctrine_text_agregar'); ?></a>
                </div>
                <?php /*********************************/ ?>

                <div class="clear"></div>

                <div id="md_objects_container" class="md_objects">
                    <?php //include_partial('mdCategory/tabs_categories', array('mdCategories' => $mdCategories, 'childs' => $childs)); ?>
                  <div id="tabs">
                    <ul id="tabs_container_ul">
                      <?php foreach($mdCategories as $mdCategory): ?>
                        <li><a href="<?php echo url_for('mdCategory/loadTabContent')."?mdCategoryId=".$mdCategory->getId()?>" title="tab_container_<?php echo $mdCategory->getId()?>" priority="<?php echo $mdCategory->getPriority()?>"> <?php echo $mdCategory->getName(); ?> </a></li>
                      <?php endforeach;?>
                    </ul>
                    <div id="tab_container_div">
                      <?php foreach($mdCategories as $mdCategory): ?>
                      <div id="tab_container_<?php echo $mdCategory->getId()?>">

                      </div>

                      <?php endforeach;?>
                    </div>
                 </div>

                </div>

            </div><!--CONTENIDO CENTER-->
        </div><!--CLASS CENTER-->
    </div><!--SOMBRA-->
</div><!--CENTER-->

<?php /** BLOQUE QUE ACOMPANIA SCROLL **/ ?>
<div id="new-category" class="md_right_container" style="visibility: hidden; float: right; margin-right: 29px; position: relative; right: 0; top: 0px;">
    <div class="md_right_shadow">
        <div class="md_center_right">
            <div class="md_content_right"></div>
        </div>
    </div>
</div>
<?php /********************************/ ?>

  <style type="text/css">
  .ui-tabs .ui-tabs-panel
  {
    padding: 0 !important;
  }
  </style>

	<script type="text/javascript">
 
  var firstTime = true;

	$(function() {
		createTabs();
	});

  function createTabs()
  {
    $("#tabs").tabs({
        select: function(event, ui) {
            var title = $(ui.tab).attr('title');
            mdCategory.getInstance().changeNewHref(title);

            $("#tab_container_div > div.ui-tabs-panel").html('');
        },

        ajaxOptions: {
            dataType: "json",
            success: function(json){
                //console.log(json);

                var place = "#tab_container_" + json.tabId;
                if($(place).length == 0){
                    //$('#tab_container_div').append("<div id='tab_container_"+json.tabId+"'></div>");
                }
                $(place).html(json.content);

                mastodontePlugin.UI.BackendBasic.getInstance().destroy();
                mastodontePlugin.UI.BackendBasic.getInstance().init('#md_accordion_container');
                mastodontePlugin.UI.BackendBasic.getInstance().afterOpen = function(json){
                    if(typeof initializeLightBox == 'function'){
                        initializeLightBox(json.id, json.className);
                    }
                }

            },
            error: function(xhr, status, index, anchor) {
                $(anchor.hash).html("Couldn't load this tab. We'll try to fix this as soon as possible. If this wouldn't be a demo.");
            }
        }
    }).find(".ui-tabs-nav").sortable({ 
                    axis: "x",
                    update: function (e, ui) {
                          var _ids = "";
                          var _classNames = "";
                          var _priorities = "";
                          var index = 1;
                         $("#tabs > ul > li > a").each(function(i){
                              //console.log(this);
                              var str = $(this).attr('title');
                              
                              str = str.replace("tab_container_", "")
                              if(_ids !== "")
                              {
                                _ids+= "|" + str;
                              }
                              else
                              {
                                _ids+= str;
                              }
                              if(_classNames !== "")
                              {
                                _classNames+= "|mdCategory";
                              }
                              else
                              {
                                _classNames+= "mdCategory";
                              }
                              if(_priorities !== 0)
                              {
                                _priorities+= "|" + index;//$(this).attr('priority');
                              }
                              else
                              {
                                _priorities+= index;//$(this).attr('priority');
                                
                              }
                              index++;
                         });
                         sendData(_ids, _classNames, _priorities);
                    }
            });
    //$("#tabs").tabs().find(".ui-tabs-nav").sortable({axis:'x'});
  }

  function sendData(_ids, _classNames, _priorities)
  {
      $.ajax({
        url: __MD_CONTROLLER_SYMFONY + "/mdSortable/sortable",
        dataType: 'json',
        type: 'POST',
        data: [{name : '_MD_Object_Ids', value: _ids}, {name: '_MD_Object_Class_Names', value: _classNames}, {name: '_MD_Priorities', value: _priorities}],
        success: function(json){
            switch(json.response)
            {
                case 'OK':break;
                case 'ERROR':alert(json.options.message);break;
                default:alert('Internal Server Error');break;
            }
        }
    });
  }
	</script>
