<?php
  //$typeName = "";
  $addUrlAux = url_for('mdDynamicContent/dynamicFilter') ;
  if($typeName)
  {
    $addUrlAux .= "?typeName=".$typeName;
  }
?>
<form id="md_filter" action="<?php echo $addUrlAux; ?>" method="post">
    <div style="float: left;">
        <?php //echo $formFilter->renderHiddenFields() ?>
        <?php echo $formFilter['_csrf_token']->render();?>
        <?php echo $formFilter['type_name']->render(array('value' => $typeName)); ?>
        <div style="float: left;">
            <h2><?php echo __('mdDynamicContentDoctrine_text_buscar palabras en los contenidos');?></h2>
            <ul class="filter">
                <li><?php echo $formFilter['md_word']->render() ?></li>
            </ul>
        </div>
        <div class="clear"></div>
        <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
            <div style="float: left;">
                <h2><?php echo __('mdDynamicContentDoctrine_text_mdCategory');?></h2>
                <ul class="filter">
                    <li><?php echo $formFilter['md_category_id']->render(array('style' => 'width:210px')) ?></li>
                </ul>
            </div>
        <?php endif;?>
        <hr>
        <?php if($isFiltered): ?>
          <input type="hidden" value="1" name="page" id="page_filter_id"/>
        <?php endif;?>
        <input id="md_object_submit_button" type="submit" value="<?php echo __('mdDynamicContentDoctrine_text_search');?>" />
    </div>
</form>
<script type="text/javascript">
    $(function() {
		$( "input:submit", "#md_filter" ).button();
    });
</script>