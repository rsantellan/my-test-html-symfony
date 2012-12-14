<h5><?php echo $categoria->getName();?></h5>
<div>
  <?php foreach($categoria->getSonsCategories() as $child): ?>
  <div style="float:left; padding-left: 5px; text-align: center">
    <strong><?php echo $child->getName();?></strong>
    <br/>
    <a href="<?php echo url_for('categorias', $child); ?>">
      <img class="category_img" src="<?php echo $child->retrieveAvatar(array(mdWebOptions::WIDTH => 100, mdWebOptions::HEIGHT => 100, mdWebOptions::CODE => mdWebCodes::RESIZECROP)); ?>" alt="<?php echo $child->getName(); ?>"/>
    </a>
  </div>
  <?php endforeach; ?>
</div>
<div class="clear"></div>