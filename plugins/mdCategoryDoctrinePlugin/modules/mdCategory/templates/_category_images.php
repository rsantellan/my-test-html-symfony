<div class="md_blocks">
    <h2 class="float_left">Imágenes</h2>
    <div class="float_left">
        <a id="opener-el" href="javascript:void(0)"><?php echo image_tag ( '/mdBasicPlugin/images/agregar.jpg' )?></a>
    </div>
    <div class="clear"></div>
    <?php if($form->getObject()->hasDefaultImage()): ?>
    <div id="md_avatar_image" class="md_avatar_image">
        <div id="loading_avatar" style="display: none; width:163px; height:163px;" class="md_loading_closed_objects"><?php echo image_tag('/mdBasicPlugin/images/md-ajax-loader.gif', array('style' => 'width:32px;height:32px;')) ?></div>
        <img src="<?php echo mdWebImage::getUrl($form->getObject()->getDefaultImage(), array(mdWebOptions::WIDTH => 163, mdWebOptions::HEIGHT => 163, mdWebOptions::CODE => mdWebCodes::RESIZE)) ?>" width="163" height="163" />
    </div><!--IMAGEN PRINCIPAL-->
    <div class="md_small_images_container">
        <ul class="md_thumbs">
            <?php $i=1; ?>

            <?php foreach ($form->getObject()->getPictures() as $m): ?>
                <li id="md_draggable_<?php echo $m->getId() ?>_<?php echo $form->getObject()->getId()  ?>" class="<?php if(($i % 5 == 0)): echo 'no_marginr'; endif; ?> md_draggable">
                    <img src="<?php echo mdWebImage::getUrl($m->getSource(), array(mdWebOptions::WIDTH => 68, mdWebOptions::HEIGHT => 68, mdWebOptions::CODE => mdWebCodes::RESIZE))?>" width="68" height="68" />
                    <div class="md_remove_thumbs" style="display: none;" onclick="removeImage(<?php echo $m->getId() ?>, <?php echo $form->getObject()->getId()  ?>);"></div>
                </li>
                <?php $i++; ?>
            <?php endforeach; ?>
        </ul>
    </div><!--THUMBS PRODUCTOS-->
    <?php endif; ?>
</div>
