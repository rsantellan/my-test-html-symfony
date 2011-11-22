<div class="div_contenedor_producto">
  <h3><?php echo $producto->getName();?></h3>
  
<div class="div_imagenes_derecha">
    <div class="imagen_grande">
    <?php 
      $instance = mdMediaManager::getInstance(mdMediaManager::ALL, $producto)->load(); 
      $avatar = null;
      if($instance->hasAlbum("default")):
        $avatar = $instance->getAvatar(NULL, true);
      endif;
    ?>
    
    <img src="<?php echo $producto->retrieveAvatar(array(mdWebOptions::WIDTH => 260, mdWebOptions::HEIGHT => 260,  mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $producto->getName(); ?>"/>
    </div>
    <?php if(!is_null($avatar)): ?>
   <div class="miniaturas">
    <?php foreach($instance->getItems() as $item): ?>
      
          <a class="grouped_images" rel="group<?php echo $producto->getId();?>" href="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 640, mdWebOptions::HEIGHT => 480,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" title="" >
              <img src="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 58, mdWebOptions::HEIGHT => 58,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" alt="" />
          </a>
      
  <?php endforeach; ?>
   </div>        
    <?php endif; ?>

  </div>  
  
  <div class="div_datos_izquierdos">
    <ul>
      <li>Descripcion </li>
      <li>Premios</li>
      <li>Presentaciones </li>
      <li>Consistencia</li>
      <li>Textura</li>
      <li>Ojos</li>
      <li>Color</li>
      <li>Sabor</li>
      <li>Humedad</li>
      <li>Materia Grasa</li>
      <li>Clasificacion</li>
      <li>Coliformes a 30</li>
      <li>Coliformes a 45</li>
      <li>Staphilococcus </li>
      <li>Salmonella</li>
      <li>Listeria</li>
    </ul>

  </div>

  

</div>
