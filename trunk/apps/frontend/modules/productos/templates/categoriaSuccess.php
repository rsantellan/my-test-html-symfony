<?php 
    slot('productos',':D'); 
    foreach($mySlots as $auxSlot)
    {
        slot($auxSlot, ':D');
    }
    
?>

<!--left start-->
<div class="left">
    <?php include_component("productos", "categoriasMenu"); ?>
    
    <br class="spacer" />
    <ul class="product_list">
    <?php foreach($listadoProductos as $producto): ?>
        <?php include_partial("productoSmallInfo", array("producto" => $producto, "slug" => $category->getSlug(), 'sf_cache_key' => $producto->getId())); ?>
        
    
    <?php endforeach; ?>
    </ul>
</div>
<!--left end-->

