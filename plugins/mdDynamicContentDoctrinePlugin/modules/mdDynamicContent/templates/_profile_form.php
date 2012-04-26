<style>
    .msg_error{
        border: 1px solid red;
    }
</style>

<?php //echo $name ?>

<form id="md_dynamic_new_profile_<?php echo $mdProfileId; ?>" action="<?php echo url_for('mdDynamicContent/saveProfileAjax'); ?>" method="post" onsubmit="return saveProfileAjax(<?php echo $mdProfileId; ?>, <?php echo $mdObjectId; ?>);" class="profile_form">
        <?php echo $form->renderHiddenFields() ?>
        <?php foreach($form as $field): ?>
            <?php if(!$field->isHidden()):?>
                <div class="md_blocks">
                    <h2><?php echo $field->renderLabelName();?></h2>
                    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                        <?php echo $field->render()?>
                    </div>
                    <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <input type="hidden" value="<?php echo $mdObjectId; ?>" name="mdObjectId" />
    <div class="clear"></div>    
</form>
