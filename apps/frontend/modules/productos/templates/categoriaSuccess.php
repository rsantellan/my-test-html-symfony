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
    <?php foreach($listadoProductos as $producto): ?>
    
        <?php echo $producto; ?>
    
    <?php endforeach; ?>
    
</div>
<!--left end-->

