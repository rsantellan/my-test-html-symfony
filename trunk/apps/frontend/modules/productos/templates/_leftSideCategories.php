<div class="search right">
  <span class="topCurve"></span>
  <div class="container_left_categories">
    <h2><span><?php echo __("productos_categorias");?></span></h2>
    <?php 
    $categories_string = $sf_user->getFlash("categoryCacheKey"); 
    $categories_list = explode("_", $categories_string);
    ?>
    <?php include_component("productos", "categoriasMenu", array('categories_string' => $categories_string, 'sf_cache_key' => $categories_string)); ?>
  </div>
  <span class="bottomCurve"></span>
</div>