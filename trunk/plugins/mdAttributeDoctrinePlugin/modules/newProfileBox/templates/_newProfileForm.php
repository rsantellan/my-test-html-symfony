<form action='<?php echo url_for('newProfileBox/proccessNewProfile'); ?>' onsubmit='return newProfileBox.getInstance().saveObjectProfile(<?php echo $objectId; ?>)' method="post" id='profile_new_form_<?php echo $objectId; ?>'>
    <?php echo $form->renderHiddenFields() ?>
<?php foreach($form as $field):
    if(!$field->isHidden()):
?>
        <div class="md_blocks">
            <h2><?php echo $field->renderLabelName();?></h2>
            <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                <?php echo $field->render()?>
            </div>
            <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
        </div>
<?php
    endif;
endforeach;?>
    <div class="clear"></div>
    <input type="hidden" name="objectId" value="<?php echo $objectId; ?>" />
    <input type="hidden" name="objectClass" value="<?php echo $objectClass; ?>" />
    <input type="submit" value="<?php echo __('mdAttributeDoctrine_text_save');?>" />
</form>
