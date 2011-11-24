<?php 
  $url = "";
  
  if(!isset($search))
  {
    $url = url_for("@detalleProducto?categoria=".$slug."&id=".$producto->getId()."&slug=".$producto->getSlug());
  }
  else
  {
    $url = url_for("@detalleProductoBusqueda?page=".$page."&search=".$search."&id=".$producto->getId()."&slug=".$producto->getSlug());
  }

?>
<div class="producto_small_container">
	
    <a href="<?php echo $url?>">
        <img src="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 165, mdWebOptions::HEIGHT => 165,  mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $producto->getName(); ?>"/>
    </a>
    <br class="spacer" />
    <label>
		<?php echo $producto; ?>    
	</label>
</div>

