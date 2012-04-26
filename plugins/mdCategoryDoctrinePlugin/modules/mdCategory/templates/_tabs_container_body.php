<?php use_helper('mdAsset');?>
<div id="loading_list_close_<?php echo $mdCategory->getId() ?>" style="display: none;" class="md_loading_closed_objects"><?php echo plugin_image_tag('mdBasicPlugin', 'md-ajax-loader.gif') ?></div>
<?php if( $i == 1 ): ?>
		<?php include_partial('mdCategory/closedCategoriesList', array('mdParentCategory' =>  $mdCategory, 'mdCategories' => $childs)); ?>
<?php endif; ?>
