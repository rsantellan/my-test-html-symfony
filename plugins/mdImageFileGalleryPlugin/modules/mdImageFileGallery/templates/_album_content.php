<?php use_helper('mdAsset');?>
<div>
    <h2><?php echo $category?> <span>(<?php echo count($images);?> <?php echo __('mdImageFileGallery_text_imagesQuantity')?>)</span></h2>
    <div class="md_add">
        <a id="mdImageFileGallery_add_<?php echo $category?>" class="open-modal iframe" href="<?php echo url_for('@mdImageFileGalleryUploader?category='. $category) ?>"><?php echo plugin_image_tag('mdImageFileGalleryPlugin','agregar.jpg');?><?php echo __('mdImageFileGallery_text_imagesAdd')?></a>
    </div>
    <div class="clear"></div>
    <div class="images_thumbs">
        <ul class="md_thumbs">
    <?php foreach ( $images as $image): ?>
                <li style="position:'relative'">
                  <div class="download"><a href="<?php echo url_for('@mdImageFileGalleryDownload?file='.base64_encode($image->getFilenameWithPath())) ?>"><?php echo image_tag("../mdMediaManagerPlugin/images/down.png");?></a></div>
                  <img src="<?php echo mdWebImage::getUrl($image->getImage(), array(
                    mdWebOptions::WIDTH => 68, 
                    mdWebOptions::HEIGHT=>68, 
                    mdWebOptions::CODE => mdWebCodes::RESIZECROP
                    )) ?>" width="68" height="68"/>
                    
                    <div class="remove" style="display:none" onclick="return mdImageFileGallery.getInstance().mdImageFileGallery_RemoveImage('<?php echo base64_encode($image->getFilenameWithPath());?>', '<?php echo $category;?>', '<?php echo url_for("@mdImageFileGalleryDelete")?>', '<?php echo __('mdImageFileGallery_text_confirmRemove')?>')"></div>
                </li>
    <?php endforeach; ?>
        </ul>
    </div><!--THUMBS PRODUCTOS-->
</div>
