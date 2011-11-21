<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php
        use_stylesheet('style.css');
        ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
    </head>
    <body>
        <!--container start -->
        <div class="container">
            <!--header start -->

            <div class="header">	
                <?php echo image_tag("logo-naturalia-204.png", array("alt" => "Naturalia", "height" => "100", "style" => "display:none")); ?>
                <?php echo image_tag("trk-small-opacity-queso.png", array("alt" => "Naturalia", "style" => "display:none")); ?>
                <?php echo image_tag("borde_pagina copia.jpg", array("alt" => "Naturalia", "class" => "header_background_image",  "style" => "display:block")); ?>
                <ul>
                    <li><a href="index.html" class="home">Inicio</a></li>
                    <li><a href="galeria.html">Galeria</a></li>
                    <li><a href="quienes_somos.html">Quienes somos</a></li>
                    <li><a href="<?php echo url_for("@location");?>"><?php echo __("menu_locaciones"); ?></a></li>
                    <li><a href="noticias.html">Noticias</a></li>
                    <li><a href="contacto.html">Contacto</a></li>
                </ul>
            </div><br class="spacer" />
            <!--header end-->      
            
                <?php echo $sf_content ?>
            
            <!--bottom start -->
            <br class="spacer" />
            <!--bottom end -->
        </div>
        <!--container end -->
        <!--footer start -->
        <div class="footer">
            <ul class="nav">
                <li><a href="#">Inicio</a>|</li>
                <li><a href="#">Services</a>|</li>
                <li><a href="#">Support</a>|</li>
                <li><a href="#">Testimonials</a>|</li>
                <li><a href="#">Blog</a>|</li>
                <li><a href="#">Duty</a>|</li>
                <li><a href="#">Contact</a></li>
            </ul><br class="spacer" />
            <p class="copyright">© float. All rights reserved.</p><br class="spacer" />
            <ul class="navlink">
                <li></li>
                <li></li>
            </ul><br class="spacer" />
        </div>
        <!--footer end -->
    </body>
</html>
