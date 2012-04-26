<form id="md_objects_filter" action="<?php echo url_for('mdProduct/filter'); ?>" method="GET">
    <div style="float: left;">
        <?php echo $formFilter->renderHiddenFields() ?>
        <h2><?php echo __("mdProduct_nombre");?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['md_name']->render(array(), array('class' => 'largeInput')) ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float: left;">
        <h2><?php echo __("mdProduct_precio");?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['price']->render() ?></li>
        </ul>
    </div>
    <div>
        <h2><?php echo __("mdProduct_moneda");?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['md_currency_id']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div style="float:left">
        <h2><?php echo __("mdProduct_cantidad");?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['quantity']->render() ?></li>
        </ul>
    </div>
    <div>
        <h2><?php echo __("mdProduct_unidades");?></h2>
        <ul class="filter">
            <li><?php echo $formFilter['md_unit_id']->render() ?></li>
        </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div>
      <h2><?php echo __("mdProduct_categoria");?></h2>
      <ul class="filter">
          <li><?php echo $formFilter['md_category_id']->render() ?></li>
      </ul>
    </div>
    <div class="clear"></div>
    <hr>
    <div>
      <h2><?php echo __("mdProduct_es publico");?></h2>
      <ul class="filter">
          <li><?php echo $formFilter['is_public']->render() ?></li>
      </ul>     
    </div>
    <div class="clear"></div>
    <hr>
    <input id="md_object_submit_button" type="submit" value="Buscar" />
</form>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#md_objects_filter" ).button();
    });
</script>
