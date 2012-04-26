<?php include_partial('menu_categorias', array('id' => $id, 'activo' => $view)); ?>

<?php if($view == 'thumbnails'): ?>
    <?php include_partial('thumbnails', array('directorio' => $id, 'archivos' => $archivos)); ?>
<?php else: ?>
    <?php include_partial('list', array('directorio' => $id, 'archivos' => $archivos)); ?>
<?php endif; ?>
