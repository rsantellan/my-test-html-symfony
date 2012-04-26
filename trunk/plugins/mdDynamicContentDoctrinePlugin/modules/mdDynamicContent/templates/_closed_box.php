<div class="<?php echo $object->getBackendClosedBoxClass(); ?>" style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for("mdDynamicContent/openBox")."?id=".$object->getId() ?>">
    <input type="hidden" name="_MD_OBJECT_ID" value="<?php echo $object->getId(); ?>" />
    <input type="hidden" name="_MD_OBJECT_CLASS_NAME" value="<?php echo $object->getObjectClass(); ?>" />
    <input type="hidden" name="PRIORITY" value="<?php echo $object->getPriority(); ?>" />
    <?php use_helper('mdAsset'); ?>
    <ul class="md_closed_object">
    <li class="md_img">
      <?php if( sfConfig::get( 'sf_plugins_dynamic_media', false ) ):  ?>
        <img alt="" id="user_<?php echo $object->getId(); ?>" src="<?php echo $object->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46,  mdWebOptions::EXACT_DIMENTIONS => true, mdWebOptions::CODE => mdWebCodes::RESIZE)); ?>" width="46" height="46" />
      <?php else: ?>
        <?php echo plugin_image_tag('mdUserDoctrinePlugin','md_user_image.jpg'); ?>
      <?php endif;?>
    </li>
    <li class="md_object_name">
      <div class="md_object_owner">
        <?php echo $object->getId()?> <span>-</span> <?php echo html_entity_decode( $object->__toString()); ?>
      </div>
      <div class="md_object_categories">
        <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
        <?php $tree = $object->getmdCategoryTree(); ?>
        <?php if($tree) $tree->show();?>
        <?php endif; ?>
      </div>
    </li>
  </ul><!--UL PRODUCTO CERRADO-->
</div>
