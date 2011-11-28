<?php
	use_javascript('jquery-1.6.4.min.js', 'first');
	use_javascript('fancybox/jquery.fancybox-1.3.1.pack.js','last');
	use_stylesheet('../js/fancybox/jquery.fancybox-1.3.1.css');
	use_javascript("location.js", 'last');
    slot('locations',':D');
?>

<!--left start-->
<div class="left">
    <h2><span class="black"><?php echo __("locales_titulo izquierdo");?></span><span class="brown"><?php echo __("locales_titulo derecho");?></span></h2>
    <?php include_partial("default/socialButtons"); ?>
	<br class="spacer" />
	<p class="darkgrey">
        <?php echo __("locales_sub titulo");?>
    </p>
    <?php foreach($locales as $local): ?>
        <?php include_partial("localInfo", array("local" => $local, 'sf_cache_key' => "nat_local_".$local->getId()));?>
    <?php endforeach; ?>
    
    <br class="spacer" />
    
    <h3><?php echo __("locales_nuestros productos se pueden encontrar en");?></h3>
    <div class="locales_venta_container">
        <?php foreach($puntosVenta as $local): ?>
            <?php include_partial("localVentaInfo", array("local" => $local, 'sf_cache_key' => "nat_local_venta_".$local->getId()));?>
        <?php endforeach; ?>
    </div>
        
</div>
<!--left end-->
