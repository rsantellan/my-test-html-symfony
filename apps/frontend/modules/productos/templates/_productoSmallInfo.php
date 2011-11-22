<div class="producto_small_container">
    <a href="javascript:void(0)">
        <img src="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 165, mdWebOptions::HEIGHT => 165,  mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $producto->getName(); ?>"/>
    </a>
    <br class="spacer" />
    <?php echo $producto; ?>    
</div>

