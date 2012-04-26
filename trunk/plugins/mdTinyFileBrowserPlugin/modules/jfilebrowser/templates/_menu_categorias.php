<?php
/**
 * Recibe $id
 * $activo: {thumbnails, list }
 */
$busqueda = '';
?>

<div class="contain_men_cat">
    <ul class="menu_cat">
        <li><a href="javascript:void(0)" onclick="verCategoria('<?php echo $id ?>', 'thumbnails' ,'<?php echo $busqueda ?>'); return false;" class="thumbnail_a<?php if($activo == 'thumbnails') echo '_activo' ?>"><?php echo __('mdFileBrowserTiny_text_thumbnails'); ?></a></li>
        <li><a href="javascript:void(0)" onclick="verCategoria('<?php echo $id ?>', 'list', '<?php echo $busqueda ?>'); return false;" class="lista_a<?php if($activo == 'list') echo '_activo' ?>"><?php echo __('mdFileBrowserTiny_text_lista'); ?></a></li>
        <li><a href="javascript:void(0)" onclick="verSubirArchivo('<?php echo $id ?>')" class="subir_img_a" title="Subir imagen en este directorio"><?php echo __('mdFileBrowserTiny_text_subir'); ?></a></li>
    </ul>
    <div class="clear"></div>
</div>