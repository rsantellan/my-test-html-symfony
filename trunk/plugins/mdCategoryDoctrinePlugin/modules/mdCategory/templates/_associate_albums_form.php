<form id="uploaderMedia" name="uploaderMedia" action="mdCategory/associateAlbums" method="post">
    <input type="hidden" name="mdMedias" value="" />
    <?php include_partial('mdCategory/combo_albums', array('albums' => $albums)); ?>
    <input id="content-lightbox-extra" type="button" onclick="associateAlbum(<?php echo $objectId ?>); return false;" value="Listo" />
</form>