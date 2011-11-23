<?php
  $category_list = explode("_", $categories_string);
?>
<ul class="productos_categories_list">
    <?php foreach ($categorias as $categoria): ?>
        <li>
            <a href="<?php echo url_for('categorias', $categoria); ?>" class="<?php if(in_array($categoria->getSlug(), $category_list)){ echo 'cat_selected'; } else { echo ''; } ?>">
                <?php echo $categoria->getName(); ?>
            </a>
		  <?php $sons = $categoria->getSonsCategories();?>
		  <?php if(count($sons) > 0): ?>
			<ul class="productos_categorias_sons_list <?php if(in_array($categoria->getSlug(), $category_list)){ echo 'productos_categorias_sons_list_visible'; } else { echo 'productos_categorias_sons_list_hidden'; } ?>">
				<?php foreach ($sons as $categoriaSon): ?>
				<li>
				  <a href="<?php echo url_for('categorias', $categoriaSon); ?>" class="<?php if(in_array($categoriaSon->getSlug(), $category_list)){ echo 'cat_son_selected'; } else { echo ''; } ?>">
					  <?php echo $categoriaSon->getName(); ?>
				  </a>
				</li>
				<?php endforeach; ?>
			</ul>
		  <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
