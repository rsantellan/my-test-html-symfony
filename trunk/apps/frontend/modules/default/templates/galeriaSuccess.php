<?php 
    slot('galeria', ':D'); 
    use_javascript("jquery-1.6.4.min.js", "first");
    use_javascript("easySlider1.5.js", "first");
    use_javascript("gallery.js", "last");
?>


<div class="image_gallery_container">
<?php if(count($images) > 0): ?>
    <div id="slider">
        <ul>
            <?php foreach($images as $image): ?>
            <li>
                <a href="javascript:void(0)">
                    
                    <img src="<?php echo mdWebImage::getUrl($image, array(mdWebOptions::WIDTH => 741, mdWebOptions::HEIGHT => 370,  mdWebOptions::CODE => mdWebCodes::RESIZECROP))?>" alt="Naturalia" width="741" height="370" />
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif; ?>    
</div>

<!--left start-->
<div class="left">
        <h2><span class="black"><?php echo __("galeria_titulo izquierdo");?></span><span class="brown"><?php echo __("galeria_titulo derecho");?></span></h2>
	<p class="darkgrey">
            <?php echo __("galeria_texto");?>
	</p>
</div>
<!--left end-->
