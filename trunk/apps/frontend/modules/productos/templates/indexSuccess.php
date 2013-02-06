<?php slot('productos',':D') ?>

<?php include_partial("leftSideCategories");?>

<!--left start-->
<div class="left">
    <h2>
	  <span class="black"><?php echo __("productos_titulo izquierdo"); ?></span><span class="brown"><?php echo __("productos_titulo derecho"); ?></span>
	</h2>
	<p class="darkgrey">
	  <?php
	  echo __("productos_bienvenidos");
	  ?>
	</p>
    <?php foreach($categorias as $categoria): ?>
    <?php include_partial('categoriaIndexInfo', array('categoria' => $categoria)); ?>
    
      <?php //var_dump($categoria->toArray());?>
    
    <?php endforeach; ?>
</div>
<!--left end-->

