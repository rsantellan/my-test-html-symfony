<div style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for("mdCategory/showOpenCategory")."?mdCategoryId=".$category->getId() ?>">
    <input type="hidden" name="_MD_OBJECT_ID" value="<?php echo $category->getId(); ?>" />
    <input type="hidden" name="_MD_OBJECT_CLASS_NAME" value="<?php echo $category->getObjectClass(); ?>" />
    <?php use_helper('mdAsset');?>
    <?php use_helper('mdAsset'); ?>
    <ul class="md_closed_object">
        <li class="md_height_fixed close" id="md_object_<?php echo $category->getId() ?>">
          <ul class="md_closed_object">
            <?php if(sfConfig::get('sf_plugins_category_media',false) and $category->hasAvatar()): ?>
              <li class="md_img">
                <img id="product_<?php echo $category->getId()?>" src="<?php echo $category->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" />
              </li>
            <?php endif;?>
            <li class="md_object_name">
              <div class="md_object_owner">
                <div><?php echo $category->getName()?></div>
              </div>
              <?php /** CATEGORIAS EN LAS QUE ESTA **/ ?>
              <div class="md_object_categories">
                  <?php foreach($category->getMdParentsCategory() as $c): ?>
                      <?php echo $c->getName() . ' / '; ?>
                  <?php endforeach; ?>
              </div>
              <?php /********************************/ ?>              
            </li>
          </ul>
        </li>
    </ul><!--UL PRODUCTO CERRADO-->
</div>
