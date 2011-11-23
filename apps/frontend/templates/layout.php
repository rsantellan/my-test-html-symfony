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
                    <li><a href="<?php echo url_for("@homepage");?>" class="<?php if(has_slot('home')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_inicio"); ?></a></li>
                    <li><a href="<?php echo url_for("@galeria");?>" class="<?php if(has_slot('galeria')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_galeria"); ?></a></li>
                    <li><a href="<?php echo url_for("@quienesSomos");?>" class="<?php if(has_slot('quienesSomos')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_Quienes somos"); ?></a></li>
                    <li><a href="<?php echo url_for("@location");?>" class="<?php if(has_slot('locations')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_locaciones"); ?></a></li>
                    <li><a href="<?php echo url_for("@productos");?>" class="<?php if(has_slot('productos')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_productos"); ?></a></li>
                    <li><a href="<?php echo url_for("@mdContact");?>" class="<?php if(has_slot('mdContact')){ echo 'home'; } else { echo ''; } ?>"><?php echo __("menu_contacto"); ?></a></li>
                </ul>
            </div><br class="spacer" />
            <!--header end-->      

			<!--right start-->
            <div class="right">
			  <?php include_component("productos", "buscador"); ?>
			  <?php if(has_slot('productos')): ?>
				<div class="search">
                    <span class="topCurve"></span>
					<div class="container_left_categories">
					  <h2><span><?php echo __("productos_categorias");?></span></h2>
            <?php 
              $categories_string = $sf_user->getFlash("categoryCacheKey"); 
              $categories_list = explode("_", $categories_string);
              //var_dump($categories_list);
            ?>
					  <?php include_component("productos", "categoriasMenu", array('categories_string' => $categories_string, 'sf_cache_key' => $categories_string)); ?>
					  
					</div>
                    <span class="bottomCurve"></span>
                </div>
			  <?php endif; ?>
            </div>
			
            
            <!--right end -->			
			
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
