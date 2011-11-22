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
    
    <?php include_partial("productoBigInfo", array("producto" => $producto, 'sf_cache_key' => $producto->getId())); ?>
    
</div>
<!--left end-->
