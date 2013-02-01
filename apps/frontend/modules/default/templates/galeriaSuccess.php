<?php 
    slot('galeria', ':D'); 
    use_javascript("jquery-1.6.4.min.js", "first");
    use_javascript("easySlider1.5.js", "first");
    use_javascript("gallery.js", "last");
    use_stylesheet("slider.css");
?>

<?php if(count($images) > 0): ?>
    <div id="slider">
        <ul>
            <?php foreach($images as $image): ?>
            <li>
                <a href="javascript:void(0)">
                    <img src="<?php echo mdWebImage::getUrl($image, array(mdWebOptions::WIDTH => 741, mdWebOptions::HEIGHT => 370,  mdWebOptions::CODE => mdWebCodes::RESIZECROP))?>" alt="Naturalia" />
                </a>
            </li>
            <?php endforeach;?>
        </ul>
    </div>
<?php endif; ?>    
