<?php slot('mdImageFileGalleryAdmin',':D') ?>
<?php
use_helper('mdAsset');
use_helper( 'JavascriptBase' );
//use_helper('mdAsset');
//use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js');
//use_plugin_javascript('mastodontePlugin', 'fancybox/jquery.fancybox-1.3.1.js');
//use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
use_plugin_javascript('mdImageFileGalleryPlugin', 'mdImageFileGallery.js');
//use_plugin_javascript('mdMediaDoctrinePlugin', 'AvatarAdmin.js');
?>
<style type="text/css">
ul.md_objects li.md_edit_objects div.images_thumbs ul.md_thumbs li div.download {
    
    float: left;
    height: 0;
    position: relative;
    right: 6px;
    top: 56px;
    width: 15px;
    display: none;
    
}
</style>
         
<div id="md_center_container">
    <div class="md_shadow">
        <div class="md_center">
            <div class="md_content_center">
                <h1><?php echo __('mdImageFileGallery_text_title')?></h1>
                <div class="clear"></div>
                <div class="main">
                    <ul id="md_objects_list" class="md_objects">
                    <?php foreach($categories as $category):
                        $images = mdImageFileGallery::getImagesByDate(array('path'=>$category,'absolute'=>false));
                        include_partial('object_edit', array('images'=>$images, 'category'=>$category));
                    endforeach;?>
                    </ul><!--UL PRODUCTO-->
                </div>
            </div><!--CONTENIDO CENTER-->
        </div><!--CLASS CENTER-->
    </div><!--SOMBRA-->
</div><!--CENTER-->
<div id="mdLightboxContent"></div>
<script type="text/javascript">

    $(document).ready(function(){
        $('a.open-modal').fancybox({ autoScale: false });

        mdImageFileGallery.getInstance().mdImageFileGallery_iniRemove();
    });

</script>
