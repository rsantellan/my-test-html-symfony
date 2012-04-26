<?php use_helper('mdAsset');?>
<div class="md_blocks">
    <h2 class="float_left"><?php echo __('mdCategoryDoctrine_text_title'); ?></h2>
    <div class="float_left">
        <a href="javascript:void(0);" onclick="return mdCategoryObjectBox.openEditCategoryObjectBox(<?php echo $mdObject->getId()?>)"><?php echo plugin_image_tag ( 'mastodontePlugin','edit.jpg' )?></a>
    </div>
    <div class="clear"></div>
    <div id='categories_tree'>
        <?php if($tree):?>
            <?php include_partial('mdCategoryObject/objectRelationBoxTreeNode', array('tree' => $tree, 'mdObject' => $mdObject))?>
        <?php endif;?>
    </div>
    <div class="clear"></div>

    <div class="md_block_add" id="bloque_agregar_cat_<?php echo $mdObject->getId()?>"></div><!--BLOQUE AGREGAR-->

</div><!--BLOQUES-->
<div class="clear"></div>
