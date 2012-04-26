<?php
/**
 * Recibe como parametros:
 * $mdCategoryInfo, que es el objeto dueño del album a mostrar
 * $album, que es el album del cual se van a mostrar las pictures
 */
?>
<div id="album_<?php echo $album->getId() ?>" class="md_blocks">
    <h2 class="float_left">Imágenes del album <?php echo $album->getTitle(); ?></h2>
    <div class="clear"></div>

    <div id="md_avatar_<?php echo $album->getId() ?>" class="md_avatar_image droppableObject">
        <div id="loading_avatar" style="display: none; width:163px; height:163px;" class="md_loading_closed_objects"><?php echo image_tag('/mdBasicPlugin/images/md-ajax-loader.gif', array('style' => 'width:32px;height:32px;')) ?></div>
        <img src="<?php echo mdWebImage::getUrl($album->getDefault(), array( mdWebOptions::WIDTH => 163, mdWebOptions::HEIGHT => 163, mdWebOptions::CODE => mdWebCodes::RESIZE ))?>" width="163" />
    </div><!--IMAGEN PRINCIPAL-->
    <div class="md_small_images_container">
        <ul class="md_thumbs">
            <?php $i=1; ?>

            <?php foreach ($album->getAllImages() as $m): ?>
                <li id="md_draggable_<?php echo $m->getId() ?>_<?php echo $album->getId()  ?>_<?php echo $mdCategoryInfo->getId() ?>_mdCategoryInfo" class="<?php if(($i % 5 == 0)): echo 'no_marginr'; endif; ?> md_draggable">
                    <img src="<?php echo mdWebImage::getUrl($m->getSource(), array( mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::CODE => mdWebCodes::RESIZE ))?>" width="68" />
                    <div class="md_remove_thumbs" style="display: none;" onclick="removeImage(<?php echo $m->getId() ?>, <?php echo $mdCategoryInfo->getId() ?>, <?php echo $album->getId() ?>);"></div>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
                
            <?php $i=1; ?>
            <?php foreach ($album->getAllFiles() as $m): ?>
                <li id="md_draggable_<?php echo $m->getId() ?>_<?php echo $album->getId()  ?>_<?php echo $object->getId() ?>_mdCategoryInfo" class="<?php if(($i % 5 == 0)): echo 'no_marginr'; endif; ?> md_draggable">
                    <div class="box_pdf">
                        <img src="<?php echo mdWebImage::getUrl($m->getObjectSource(), array( mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::EXACT_DIMENTIONS => true )) ?>" width="68" height="68" title="<?php echo $m->getName(); ?>" />
                        <div class="md_remove_thumbs" style="display: none;" onclick="removeFile(<?php echo $m->getId() ?>, <?php echo $object->getId() ?>, <?php echo $album->getId() ?>);"></div>
                    </div>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>

        </ul>
    </div><!--THUMBS PRODUCTOS-->
</div>
