<?php 
    use_helper('mdAsset');
    use_plugin_javascript('mastodontePlugin', 'jquery-ui-1.8.4/js/jquery-1.4.2.min.js', 'first');
    use_plugin_stylesheet('mastodontePlugin', '../js/fancybox/jquery.fancybox-1.3.1.css');
    use_plugin_javascript('mastodontePlugin','fancybox/jquery.fancybox-1.3.1.pack.js','last');
    use_javascript("location.js", 'last');
?>

<!--left start-->
<div class="left">
    <h2><span class="black"><?php echo __("locales_titulo izquierdo");?></span><span class="brown"><?php echo __("locales_titulo derecho");?></span></h2>
    <p class="darkgrey">
        <?php echo __("locales_sub titulo");?>
<!--        <strong>Nuestros locales,</strong> estan en:-->
    </p>
    <?php foreach($locales as $local): ?>
        <?php include_partial("localInfo", array("local" => $local, 'sf_cache_key' => "nat_local_".$local->getId()));?>
    <?php endforeach; ?>
    
    <br class="spacer" />
    
    <h3>Gente que lo vende...</h3>
    <div class="locales_venta_container">
        <?php foreach($puntosVenta as $local): ?>
            <?php include_partial("localVentaInfo", array("local" => $local, 'sf_cache_key' => "nat_local_venta_".$local->getId()));?>
        <?php endforeach; ?>
    </div>
        
</div>
<!--left end-->
<!--right start-->
<div class="right">
    <div class="search">
        <span class="topCurve"></span>
        <form class="searchForm" name="form1" method="post" action="">
            <h2><span>Newsletter</span></h2>
            <input name="textfield" type="text" value="E-mail" />

            <input type="submit" value="inscribirse" class="button" />					

            <br class="spacer" />     
        </form> 
        <span class="bottomCurve"></span>
    </div>
</div><br class="spacer" />
<!--right end -->