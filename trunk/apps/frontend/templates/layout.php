<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <?php include_http_metas() ?>
        <?php include_metas() ?>
        <?php include_title() ?>
        <link rel="shortcut icon" href="/favicon.ico" />
        <?php
          use_stylesheet("Estilos.css");
          use_stylesheet("productos.css");
        ?>
        <?php include_stylesheets() ?>
        <?php include_javascripts() ?>
 
    </head>
    
    <body>
      <div align="center">
        <div id="contenedor">
          <div id="cabezal">
            <?php echo image_tag("cabezal.png", array("alt" => "Naturalia", "width" => 993, "height"=>342)); ?>
          </div>
          <div id="Menu">
              <?php if(has_slot('home')): ?>
                  <?php echo image_tag("menu-r-home.png", array("alt" => __("menu_inicio"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@homepage");?>">
                    <?php echo image_tag("menu-v-hhomea.png", array("alt" => __("menu_inicio"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
            
              <?php if(has_slot('quienesSomos')): ?>
                  <?php echo image_tag("menu-r-historia.png", array("alt" => __("menu_historia"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@historia");?>">
                    <?php echo image_tag("menu-v-historia.png", array("alt" => __("menu_historia"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
              
              <?php if(has_slot('productos')): ?>
                  <?php echo image_tag("menu-r-productos.png", array("alt" => __("menu_productos"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@productos");?>">
                    <?php echo image_tag("menu-v-productos.png", array("alt" => __("menu_productos"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
              
              <?php if(has_slot('galeria')): ?>
                  <?php echo image_tag("menu-r-galeria.png", array("alt" => __("menu_galeria"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@galeria");?>">
                    <?php echo image_tag("menu-v-galeria.png", array("alt" => __("menu_galeria"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
              
              <?php if(has_slot('locations')): ?>
                  <?php echo image_tag("menu-r-locales.png", array("alt" => __("menu_locaciones"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@location");?>">
                    <?php echo image_tag("menu-v-locales.png", array("alt" => __("menu_locaciones"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
              
              <?php if(has_slot('mdContact')): ?>
                  <?php echo image_tag("menu-r-contacto.png", array("alt" => __("menu_contacto"), "width" => 127, "height"=>29)); ?>
              <?php else: ?>
                  <a href="<?php echo url_for("@mdContact");?>">
                    <?php echo image_tag("menu-v-contacto.png", array("alt" => __("menu_contacto"), "width" => 127, "height"=>29)); ?>
                  </a>
              <?php endif; ?>
          </div>
          <?php echo $sf_content ?>
          
          <div align="center">
            <div id="pie">
                <?php echo image_tag("pie.jpg", array("width" => 1045, "height"=>74)); ?>
            </div>
          </div>
          
        </div>
          
      </div>
        <!--footer end -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) {return;}
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>

    </body>
<!-- Place this render call where appropriate -->
</html>
