<?php slot('mdProduct',':D');
use_helper('mdAsset');
use_javascript('tiny_mce/tiny_mce.js', 'last');
use_plugin_javascript('mdCategoryDoctrinePlugin','mdCategoryObjectBox.js','last');
use_plugin_javascript('mdShoppingDoctrinePlugin', 'Modules/mdProduct.js', 'last');

if( sfConfig::get( 'sf_plugins_shopping_media', false ) ):
    include_partial('mdMediaContentAdmin/javascriptInclude');
endif;

?>
<?php 
if( sfConfig::get( 'sf_plugins_shopping_select_and_add_multiple_widget', false ) ):
    use_plugin_javascript('mastodontePlugin', 'jquery.multiSelect-1.2.2/jquery.bgiframe.min.js', 'last');
    use_plugin_javascript('mastodontePlugin', 'jquery.multiSelect-1.2.2/jquery.multiSelect.js', 'last');
    use_plugin_stylesheet('mastodontePlugin', '../js/jquery.multiSelect-1.2.2/jquery.multiSelect.css', 'last');
    use_plugin_javascript('mdAttributeDoctrinePlugin', 'mdWidgetSelectAndAddMultipleChoices.js', 'last');
endif;
$sortable = sfConfig::get( 'sf_plugins_shopping_sortable', false );
$objectClass = "mdProduct";
?>

<script type="text/javascript">
    <?php if( sfConfig::get( 'sf_plugins_shopping_category', false ) ):  ?>
        var mdCategoryObjectBox = new MdCategoryObjectBox({'object_class':'mdProduct'});
    <?php endif; ?>
</script>
<?php
$parameters;
if(isset($typeName))
{
  $parameters = array('addToUrl'=>'typeName='.$typeName,'type'=>$typeName);
}
else
{
  $parameters = array();
}
?>
<?php include_component('backendBasic', 'backendTemplate', array(
    'module' => 'mdProduct',
    'objects' => $pager,
    'formFilter' => $formFilter,
    'parameters' => $parameters,
    'isSortable' => $sortable,
    'objectClass' => $objectClass
)); ?>
