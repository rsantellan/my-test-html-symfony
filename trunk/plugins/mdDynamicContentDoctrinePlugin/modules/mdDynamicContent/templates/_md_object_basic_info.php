<form action='<?php echo url_for('mdDynamicContent/processMdObjectAjax'); ?>' method="post" id='md_object_edit_form_<?php echo $form->getObject()->getId() ?>'>
    <?php echo $form->renderHiddenFields()?>
    
    <div class="md_open_object_top" <?php if( !sfConfig::get( 'sf_plugins_dynamic_show_publish_at', false ) ){ echo 'style="display: none;"'; }  ?>>
        <div class="md_blocks">
            <h2><?php echo __('mdDynamicContentDoctrine_text_publishAt') ?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['publish_at']->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $form['publish_at']->render();?>
            </div>
            <div><?php if($form['publish_at']->hasError()): echo $form['publish_at']->renderLabelName() .': '. $form['publish_at']->getError();  endif; ?></div>
            <h2><?php echo __('mdDynamicContentDoctrine_text_publishUpTo') ?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['publish_up_to']->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $form['publish_up_to']->render();?>
            </div>
            <div><?php if($form['publish_up_to']->hasError()): echo $form['publish_up_to']->renderLabelName() .': '. $form['publish_up_to']->getError();  endif; ?></div>
        </div>
    </div><!--ABIERTO TOP-->
    <div class="md_blocks" <?php if( !sfConfig::get( 'sf_plugins_dynamic_show_is_visible', false ) ){ echo 'style="display: none;"'; }  ?>>
        <h2><?php echo __('mdDynamicContentDoctrine_text_isVisible') ?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['is_public']->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $form['is_public']->render();?>
            </div>
            <div><?php if($form['is_public']->hasError()): echo $form['is_public']->renderLabelName() .': '. $form['is_public']->getError();  endif; ?></div>
    </div>
 </form>

<div class="clear"></div>
