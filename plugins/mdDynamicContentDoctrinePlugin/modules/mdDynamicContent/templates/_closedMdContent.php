<?php use_helper('mdAsset'); ?>
<li class="md_height_fixed" id='md_object_<?php echo $md_object->getId() ?>'>
    <div id="loading_close_<?php echo $md_object->getId() ?>" style="display: none;" class="md_loading_closed_objects"><?php echo plugin_image_tag('mastodontePlugin','md-ajax-loader.gif'); ?></div>
    <ul class="md_closed_object">
    	<li class="md_img">
            <?php if( sfConfig::get( 'sf_plugins_dynamic_media', false ) ):  ?>
            <img id="user_<?php echo $md_object->getId()?>" alt="" src="<?php echo $md_object->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46, mdWebOptions::CODE => mdWebCodes::RESIZE )); ?>" />
            <?php else: ?>
                <?php echo plugin_image_tag('mdUserDoctrinePlugin','md_user_image.jpg'); ?>
            <?php endif;?>
        </li>
    	<li class="md_object_name">
        	<div class="md_object_owner">
                    <?php echo $md_object->getId()?> <span>-</span> <?php echo html_entity_decode( $md_object->__toString()); ?>
        	</div>
            <div class="md_object_categories">							
              <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
                <?php $tree = $md_object->getmdCategoryTree(); ?>
                <?php if($tree) $tree->show();?>
              <?php endif; ?>
            </div>
        </li>
        <li class="md_value"><?php //echo $product->getDisplayPrice()?></li>
        <li class="md_edit">
            <a href="mdDynamicContent/getDetailAjax?mdObjectId=<?php echo $md_object->getId() ?>" onclick='mdObjectList.openObject(<?php echo $md_object->getId() ?>,this, event);'><?php echo __('mdDynamicContentDoctrine_text_edit') ?></a>
        </li>
    </ul><!--UL PRODUCTO CERRADO-->
</li><!--LI PRODUCTO-->
