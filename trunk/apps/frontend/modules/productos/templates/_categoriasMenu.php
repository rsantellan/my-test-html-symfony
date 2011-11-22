<ul class="productos_categories_list">
    <?php foreach ($categorias as $categoria): ?>
        <li>
            <a href="<?php echo url_for('categorias', $categoria); ?>" class="<?php if(has_slot($categoria->getSlug())){ echo 'cat_selected'; } else { echo ''; } ?>">
                <?php echo $categoria->getName(); ?>
            </a>
        </li>
    <?php endforeach; ?>
</ul>