<?php if($show): ?>
  <?php include_partial("productoSmallInfo", array("producto" => $producto, "slug" => $slug, 'sf_cache_key' => $producto->getId())); ?>
<?php endif; ?>
