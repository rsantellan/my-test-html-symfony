<?php
if($typeName)
{
  slot('mdDynamicContent_'.$typeName,':D');
}
else
{
  slot('mdDynamicContent',':D');
}

use_helper('mdAsset');
use_helper( 'JavascriptBase' );

if( sfConfig::get('sf_plugins_dynamic_googleMap_manage', false) && sfConfig::get('sf_plugins_dynamic_googleMap_' . $typeName, false) )
{ ?>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no" /> <?php
    use_javascript("http://maps.google.com/maps/api/js?sensor=true");
    use_plugin_javascript('mdGoogleMapDoctrinePlugin', 'mdGoogleMapControlBackend.js', 'last');
    use_plugin_javascript('mdGoogleMapDoctrinePlugin', 'mdGoogleMap.js', 'last');
}

if( sfConfig::get( 'sf_plugins_relation_content_manage', false ) )
{
    use_plugin_stylesheet('mdUserDoctrinePlugin', 'flexigrid/flexigrid.css');
    use_plugin_javascript('mdUserDoctrinePlugin', 'flexigrid.js', 'last');
    use_plugin_javascript('mdUserDoctrinePlugin', 'mdRelationContent.js', 'last');
}

use_plugin_javascript('mdDynamicContentDoctrinePlugin', 'mdDynamicContent.js', 'last');
use_plugin_javascript('mdAttributeDoctrinePlugin', 'newProfileBox.js', 'last');
use_plugin_javascript('mastodontePlugin', 'flowplayer/flowplayer-3.2.4.min.js', 'last');

if(sfConfig::get( 'sf_plugins_dynamic_multiple_datepicker', false )){
    use_plugin_javascript('mdAttributeDoctrinePlugin','datepicker/js/datepicker.js');
    use_plugin_javascript('mdAttributeDoctrinePlugin','datepicker/js/eye.js');
    use_plugin_javascript('mdAttributeDoctrinePlugin', 'datepicker/js/utils.js');
    use_plugin_javascript('mdAttributeDoctrinePlugin', 'datepicker/js/layout.js?ver=1.0.2');
    use_plugin_stylesheet('mdAttributeDoctrinePlugin', '../js/datepicker/css/datepicker.css');
}

if( sfConfig::get( 'sf_plugins_user_media', false ) )
{
  include_partial('mdMediaContentAdmin/javascriptInclude');
}
if( sfConfig::get( 'sf_plugins_dynamic_media', false ) )
{
  include_partial('mdMediaContentAdmin/javascriptInclude');
}
if( sfConfig::get( 'sf_plugins_dynamic_category', false ) )
{
    use_plugin_javascript('mdCategoryDoctrinePlugin', 'mdCategoryObjectBox.js');
}
if( sfConfig::get( 'sf_plugins_dynamic_change_box_colors', false ) )
{
    use_stylesheet("backendColors.css");
}
use_javascript('tiny_mce/tiny_mce.js', 'last');

if( sfConfig::get( 'sf_plugins_dynamic_feature', false ) ){
  use_plugin_javascript('mdFeatureDoctrinePlugin','mdFeatureBox.js','last');
}
?>
<script type="text/javascript">
    <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
    var mdCategoryObjectBox = new MdCategoryObjectBox({'object_class':'mdDynamicContent'});
    <?php endif; ?>
</script>
<?php
$parameters;
if($typeName)
{
  $parameters = array(
                    'addToUrl'=>'typeName='.$typeName,
                    'type'=> $typeName);
}
else
{
  $parameters = array();
}
include_component('backendBasic', 'backendTemplate', array(
    'module' => 'mdDynamicContent',
    'objects' => $pager,
    'formFilter' => $formFilter,
    'parameters' => $parameters,
    'isSortable' => sfConfig::get('sf_plugins_dynamic_priority', false),
    'objectClass' => 'mdDynamicContent',
    'isFiltered' => $isFiltered
    
));
?>
