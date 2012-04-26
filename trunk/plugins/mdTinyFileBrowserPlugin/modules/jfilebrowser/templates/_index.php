<div class="contain_men_cat">
  <ul class="menu_cat">
    <li><a href="javascript:void(0)" onclick="verCrearDirectorio();" class="crear_cat_a" title="<?php echo __('mdFileBrowserTiny_text_crearDirectorio'); ?>"><?php echo __('mdFileBrowserTiny_text_crearDirectorio'); ?></a></li>
  </ul>
  <div class="clear"></div>
</div>

<?php if(count($directorios) > 0): ?>
<?php //if($num_paginas > 1) echo '<div class="paginacion">'.$paging->fetchNavegacion().'</div>'; ?>
    <h2 class="titulo2"><?php echo __('mdFileBrowserTiny_text_directorios'); ?></h2>
    <ul class="lista_cat">
        <?php $i = 1; ?>
        <?php foreach($directorios as $directorio): ?>
            <li>
                <form name="form_<?php echo $i; ?>" method="post" action="/backend.php/jfilebrowser/borrarDirectorio" class="borr_cat_fm" onsubmit="jFileBrowserDialog.confirmar('estas seguro que quieres borrar este directorio', <?php echo $i; ?>); return false;">
                    <input type="image" name="borrar_cat_bt" id="borrar_cat_bt" src="img/delete.png" />
                    <span class="enviar_td">
                        <input type="hidden" name="nombre" value="<?php echo $directorio->name ?>" />
                    </span>
                </form>
                <span class="info_cat_sp"><a href="javascript:void(0)" onclick="verCategoria('<?php echo $directorio->name ?>')"  <?php if($directorio->cant > 0) echo ' class="cat_con_img"';?>><?php echo $directorio->name; ?></a> (<?php echo $directorio->cant; ?>)</span>
            </li>
        <?php $i++; ?>
        <?php endforeach; ?>
    </ul>

<?php else :?>
    <?php echo __('mdFileBrowserTiny_text_noExisteDirectorio'); ?>
<?php endif; ?>
