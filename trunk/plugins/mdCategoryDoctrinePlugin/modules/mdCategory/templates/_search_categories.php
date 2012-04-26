<div class="md_right_shadow">
    <div class="md_center_right">
        <div class="md_content_right">
            <form id="md_objects_filter" action="<?php echo url_for('mdProduct/searchProducts'); ?>" method="post">
                <div style="float: left;">
                    <h2><?php echo $mdProductFilter['md_name']->renderLabel() ?></h2>
                    <ul class="filter">
                        <li><?php echo $mdProductFilter['md_name']->render(array(), array('class' => 'largeInput')) ?></li>
                    </ul>
                </div>
                <div class="clear"></div>
                <hr>
                <div style="float: left;">
                    <h2><?php echo $mdProductFilter['price']->renderLabel() ?></h2>
                    <ul class="filter">
                        <li><?php echo $mdProductFilter['price']->render() ?></li>
                    </ul>
                </div>
                <div>
                    <h2><?php echo $mdProductFilter['md_currency_id']->renderLabel() ?></h2>
                    <ul class="filter">
                        <li><?php echo $mdProductFilter['md_currency_id']->render() ?></li>
                    </ul>
                </div>
                <div class="clear"></div>
                <hr>
                <div style="float:left">
                    <h2><?php echo $mdProductFilter['quantity']->renderLabel() ?></h2>
                    <ul class="filter">
                        <li><?php echo $mdProductFilter['quantity']->render() ?></li>
                    </ul>
                </div>
                <div>
                    <h2><?php echo $mdProductFilter['md_unit_id']->renderLabel() ?></h2>
                    <ul class="filter">
                        <li><?php echo $mdProductFilter['md_unit_id']->render() ?></li>
                    </ul>
                </div>
                <div class="clear"></div>
                <hr>
                <div>
                  <h2><?php echo $mdProductFilter['md_category_id']->renderLabel() ?></h2>
                  <ul class="filter">
                      <li><?php echo $mdProductFilter['md_category_id']->render() ?></li>
                  </ul>
                </div>
                <div class="clear"></div>
                <hr>
                <div>
                    <?php echo $mdProductFilter['is_public']->render() ?>
                </div>
                <div class="clear"></div>
                <hr>
                <input id="md_object_submit_button" type="button" onclick="search();" value="Buscar" />
            </form>
            <div class="clear"></div>
        </div><!--CONTENIDO LEFT-->
    </div>
</div>