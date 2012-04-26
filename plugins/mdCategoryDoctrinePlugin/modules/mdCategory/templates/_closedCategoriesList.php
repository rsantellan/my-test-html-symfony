<div id="md_accordion_container<?php //echo $mdParentCategory->getId(); ?>" class="md_objects">
    <?php $i = 1; ?>
    <?php foreach($mdCategories as $category):?>

        <?php $first = ($i == 1 && sfConfig::get('sf_plugins_category_show_root', true)); ?>
        <div>
            <div class="accordion-header" >
              <?php include_partial('closedCategory',array('category'=> $category, 'first' => $first)); ?>
            </div>
            <!--init accordion body empty -->
            <div class="accordion-body"></div>
        </div>
    <?php $i++; ?>
    <?php endforeach;?>

</div><!--UL PRODUCTO-->
