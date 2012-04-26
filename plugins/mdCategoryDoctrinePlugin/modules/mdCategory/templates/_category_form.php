<form id='category_new_form_' class="category_new_form" action='<?php echo url_for('mdCategory/createCategory'); ?>' method="post">
    <?php echo $form->renderHiddenFields()?>
    <div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
      <?php include_partial('category_info', array('form' => $form)); ?>
      <?php if( sfConfig::get( 'sf_plugins_category_attributes', false ) ):  ?>
          <?php use_helper('JavascriptBase'); ?>
          <?php foreach($form['mdAttributes'] as $attForm): ?>
            <?php include_partial('md_category_profile', array('form' => $attForm)); ?>
          <?php endforeach; ?>
      <?php endif; ?>      
    </div>
    <div id="new_product_extra" style="display: none;"></div>

    
    <div class="md_save" style="float:right;">
        <a href="javascript:void(0)" onclick="mdCategory.getInstance().createCategory('<?php echo url_for('mdCategory/loadTabContent')?>', '<?php echo url_for('mdCategory/showClosedCategory')?>'); "><?php echo __('mdCategoryDoctrine_text_save'); ?></a>
        <?php if($form->isNew()): ?>
          <a class="md_cancel_button" href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();"><?php echo __('mdCategoryDoctrine_text_cancel'); ?></a>
        <?php else: ?>
          <a class="md_cancel_button" href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();"><?php echo __('mdCategoryDoctrine_text_cancel'); ?></a>
        <?php endif; ?>
        
    </div>
    
    <div class="clear"></div>
</form>
<script type="text/javascript">
    $(function() {
      $( "a", ".md_save" ).button();
    });
</script>
