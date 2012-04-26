    <?php $object = $form->getObject()->getMdCategoryInfo(); ?>

<?php if($object->getId() != NULL): ?>
    <div class="md_blocks">
        <h2 class="float_left">Subir Imágenes</h2>
        <div class="float_left">
            <a id="opener-el" href="javascript:void(0)"><?php echo image_tag ( '/mdBasicPlugin/images/agregar.jpg' )?></a>
        </div>
        <div class="clear"></div>
    </div>

    <div id="images_block" class="md_blocks md_image_block_width">
        <div id="images_container" style="border: silver solid;">

            <ul id="albums_tabs" class="subsection_tabs">
            <?php foreach($object->retrieveMdMedia()->getMdMediaAlbum() as $mdMediaAlbum): ?>
                <li class="tab"><a href="#album_<?php echo $mdMediaAlbum->getId() ?>"><?php echo  $mdMediaAlbum->getTitle() ?></a></li>
            <?php endforeach; ?>
            </ul>

            <?php foreach($object->retrieveMdMedia()->getMdMediaAlbum() as $mdMediaAlbum): ?>
               <?php include_partial('mdCategory/category_album', array('album' => $mdMediaAlbum, 'mdCategoryInfo' => $object)); ?>
            <?php endforeach; ?>
        </div>
    </div>
    
    <script>
        var block_height = $('images_block').getHeight() + 'px';
        $('images_container').setStyle( { 'height' : block_height });
        var albums_tabs = new Control.Tabs('albums_tabs');

    </script>

<?php endif; ?>

