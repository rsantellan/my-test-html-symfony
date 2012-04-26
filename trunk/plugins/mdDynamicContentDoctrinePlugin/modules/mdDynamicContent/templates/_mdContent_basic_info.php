<?php use_javascript('tiny_mce/tiny_mce.js') ?>
<?php use_helper('mdAsset') ?>
<input type="hidden" value="<?php echo $form->getObject()->getId() ?>" name="id" />
<div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
    
    <div class="md_blocks" <?php if( !sfConfig::get( 'sf_plugins_dynamic_show_publish_at', false ) ){ echo 'style="display: none;"'; }  ?> style="margin-bottom: 2px;">
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
    <div class="md_blocks" <?php if( !sfConfig::get( 'sf_plugins_dynamic_show_is_visible', false ) ){ echo 'style="display: none;"'; }  ?>>
        <h2><?php echo __('mdDynamicContentDoctrine_text_isVisible') ?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['is_public']->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $form['is_public']->render();?>
            </div>
            <div><?php if($form['is_public']->hasError()): echo $form['is_public']->renderLabelName() .': '. $form['is_public']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks">
      <?php foreach($form['mdAttributes'] as $mdAttForm):?>
        <?php foreach($mdAttForm as $field): ?>
          <?php if(!$field->isHidden()): ?>
            <div class="md_blocks">
                <h2><?php echo $field->renderLabelName();?></h2>
                <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                    <?php echo $field->render()?>
                </div>
                <div>
                    <?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?>
                </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
    </div>
</div>
