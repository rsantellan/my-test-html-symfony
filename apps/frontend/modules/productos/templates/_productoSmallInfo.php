<div class="producto_small_container">
	
    <a href="<?php echo url_for("@detalleProducto?categoria=".$slug."&id=".$producto->getId()."&slug=".$producto->getSlug()); ?>">
        <img src="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 165, mdWebOptions::HEIGHT => 165,  mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $producto->getName(); ?>"/>
    </a>
    <br class="spacer" />
    <label>
		<?php echo $producto; ?>    
	</label>
</div>

