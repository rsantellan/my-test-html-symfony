<?php 
    slot('productos',':D'); 
    foreach($mySlots as $auxSlot)
    {
        slot($auxSlot, ':D');
    }
    
?>

<!--left start-->
<div class="left">
    <div>
      <a href="<?php echo url_for('categorias', $category)."?page=".$page?>"> <?php echo __("producto_volver"); ?></a>
    </div>
    <?php include_partial("productoBigInfo", array("producto" => $producto, 'sf_cache_key' => $producto->getId())); ?>
</div>
<!--left end-->
