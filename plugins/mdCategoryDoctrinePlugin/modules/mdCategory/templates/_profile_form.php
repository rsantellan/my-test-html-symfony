<style>
    .msg_error{
        border: 1px solid red;
    }
</style>

<form id="product_new_profile_<?php echo $mdProfileId; ?>" action="<?php echo url_for('homero/createProfile'); ?>" method="post" onsubmit="return createProfile(<?php echo $mdProfileId; ?>, <?php echo $mdProduct->getId(); ?>);">
    <?php echo $form->renderHiddenFields(); ?>
    <?php foreach($form as $field): ?>
        <?php if(!$field->isHidden()): ?>
            <div class="md_blocks">
                <h2><?php echo $field->renderLabelName();?></h2>
                <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                    <?php echo $field->render()?>
                </div>
                <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
            </div>
        <?php endif; ?>
    <?php endforeach; ?>
    <input type="hidden" name="mdProductId" value="<?php echo $mdProduct->getId(); ?>" />
    <div class="clear"></div>
    <input type="submit" value="Save" />
</form>
<br />
<div class="msg_error" style="display:none;"></div>