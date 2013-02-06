<h3><?php echo $categoria->getName();?></h3>
<div>
  <?php foreach($categoria->getSonsCategories() as $child): ?>
  <div class="category_index_small_info">
    <a href="<?php echo url_for('categorias', $child); ?>">
      <img class="category_img" src="<?php echo $child->retrieveAvatar(array(mdWebOptions::WIDTH => 100, mdWebOptions::HEIGHT => 100, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $child->getName(); ?>"/>
    </a>
    <br/>
    <strong><?php echo $child->getName();?></strong>
  </div>
  <?php endforeach; ?>
</div>
<div class="clear"></div>