<?php 
  use_javascript("jquery-1.6.4.min.js", "first"); 
  use_javascript("cloud-zoom.1.0.2.min.js", "last");
  use_javascript("productoBig.js", "last");
  use_stylesheet("cloud-zoom.css");
?>
<div class="producto_social_buttons_containers">
  <?php include_partial("default/socialButtons"); ?>
</div>
<br class="spacer" />
<div class="div_contenedor_producto">
  <h3><?php echo $producto->getName(); ?></h3>
  
  <div class="div_imagenes_derecha">
    <div class="imagen_grande">
	  <?php
	  $instance = mdMediaManager::getInstance(mdMediaManager::ALL, $producto)->load();
	  $avatar = null;
	  if ($instance->hasAlbum("default")):
		$avatar = $instance->getAvatar(NULL, true);
	  endif;
	  ?>
	  <a href="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 520, mdWebOptions::HEIGHT => 520, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" class = 'cloud-zoom' id='zoom1' rel="showTitle: false, adjustX:-4, adjustY:-4">
      <img class="product_image_big" src="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 260, mdWebOptions::HEIGHT => 260, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $producto->getName(); ?>"/>
	  </a>
    </div>
	<?php if (!is_null($avatar)): ?>
  	<div class="miniaturas">
		<?php foreach ($instance->getItems() as $item): ?>
		  <a class="grouped_images" rel="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 520, mdWebOptions::HEIGHT => 520, mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" href="javascript:void(0)" title="" >
        <img src="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 58, mdWebOptions::HEIGHT => 58, mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" alt="" rel="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 260, mdWebOptions::HEIGHT => 260, mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>"/>
		  </a>
		<?php endforeach; ?>
  	</div>        
	<?php endif; ?>

  </div>  
  <?php $profile = mdProfileHandler::getInstance($producto)->loadProfile('productos'); ?>

  <div class="producto_upper_data">
    <div class="div_datos_producto">
      <span><?php echo __("producto_Descripcion label"); ?></span>
      <br/>
      <?php echo $profile->getValue("descripcion") ?>
    </div>
    <?php $aux = $profile->getValue("premios"); 
    if($aux != ""): ?>
    <div class="div_datos_producto">
      <span><?php echo __("producto_Premios label"); ?></span>
      <br/>
      <?php echo $aux; ?>
    </div>
    <?php endif;?>
    <?php $aux = $profile->getValue("presentaciones"); 
    if($aux != ""): ?>
    <div class="div_datos_producto">
      <span><?php echo __("producto_Presentaciones label"); ?></span>
      <br/>
      <?php echo $aux ?>
    </div>
    <?php endif;?>
  </div>
  <br class="spacer" />
  <div class="producto_lower_data">
  <?php $aux = $profile->getValue("consistencia"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Consistencia label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("textura"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Textura label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
  <?php $aux = $profile->getValue("ojos"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Ojos label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("color"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Color label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
  <?php $aux = $profile->getValue("sabor"); 
    if($aux != ""): ?>  
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Sabor label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("humedad"); 
    if($aux != ""): ?>  
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Humedad label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
  <?php $aux = $profile->getValue("materiaGrasa"); 
    if($aux != ""): ?> 
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Materia Grasa label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("clasificacion"); 
    if($aux != ""): ?> 
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Clasificacion label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
  <?php $aux = $profile->getValue("coliformes35"); 
    if($aux != ""): ?> 
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Coliformes a 30 label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("coliformes45"); 
    if($aux != ""): ?>
	<div class="div_datos_producto"> 
	  <span><?php echo __("producto_Coliformes a 45 label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
  <?php $aux = $profile->getValue("staphillococus"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Staphilococcus label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  <?php $aux = $profile->getValue("salmonella"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Salmonella label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
	<div class="clear"></div>
    <?php $aux = $profile->getValue("listerya"); 
    if($aux != ""): ?>
	<div class="div_datos_producto">
	  <span><?php echo __("producto_Listeria label"); ?></span>
	  <br/>
	  <?php echo $aux ?>
	</div>
  <?php endif;?>
  </div>

</div>
