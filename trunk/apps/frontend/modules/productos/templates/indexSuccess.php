<?php slot('productos',':D') ?>

<div id="caja7">

    <h1><m><?php echo __("productos_bienvenidos"); ?></m></h1>
    <table width="800" cellspacing="30px">
	<tr>
	    <td width="352">
		<?php foreach($categorias as $categoria): ?>
		    <?php include_partial('categoriaIndexInfo', array('categoria' => $categoria)); ?>
		<?php endforeach; ?>
	    </td>
	</tr>
    </table>
</div>

