<ul class="productos_categories_list">
    <?php foreach ($categorias as $categoria): ?>
        <li>
            <a href="<?php echo url_for('categorias', $categoria); ?>" class="<?php if(has_slot($categoria->getSlug())){ echo 'cat_selected'; } else { echo ''; } ?>">
                <?php echo $categoria->getName(); ?>
            </a>
		  <?php $sons = $categoria->getSonsCategories();?>
		  <?php if(count($sons) > 0): ?>
			<ul class="productos_categorias_sons_list <?php if(has_slot($categoria->getSlug())){ echo 'productos_categorias_sons_list_visible'; } else { echo 'productos_categorias_sons_list_hidden'; } ?>">
				<?php foreach ($sons as $categoriaSon): ?>
				<li>
				  <a href="<?php echo url_for('categorias', $categoriaSon); ?>" class="<?php if(has_slot($categoriaSon->getSlug())){ echo 'cat_son_selected'; } else { echo ''; } ?>">
					  <?php echo $categoriaSon->getName(); ?>
				  </a>
				</li>
				<?php endforeach; ?>
			</ul>
		  <?php endif; ?>
        </li>
    <?php endforeach; ?>
</ul>
