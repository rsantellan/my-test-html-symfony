<form action="<?php echo url_for('mdCategoryObject/newCategory') ?>" onsubmit="saveNewCategory(this, event); return false;">
    <?php echo $form['object_class_name']->render(array('value' => $objclass)) ?>
    name: <?php echo $form[$sf_user->getCulture()]['name']->render() ?>
    parent: <?php echo $form['md_category_parent_id']->render() ?>
    <?php echo $form['_csrf_token']->render() ?>

    <?php //echo $form ?>
    <input type="submit" value="guardar" />
</form>
<div id="addCategoryErrors"></div>