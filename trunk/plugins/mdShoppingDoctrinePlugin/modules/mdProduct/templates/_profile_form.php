<?php $contador = 0; ?>
<form id="md_dynamic_new_profile_<?php echo $mdProfileId; ?>" action="<?php echo url_for('mdProduct/saveProfileAjax'); ?>" method="post" onsubmit="return saveProfileAjax(<?php echo $mdProfileId; ?>, <?php echo $mdObjectId; ?>);" class="profile_form">
        <?php echo $form->renderHiddenFields() ?>
        <?php foreach($form as $field): ?>
            <?php if(!$field->isHidden()):?>
                <div class="md_blocks">
                    <h2><?php echo $field->renderLabelName();?></h2>
                    <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                        <?php echo $field->render()?>
                    </div>
                    <?php if($field->hasError()):  echo '<div>'.$field->renderLabelName() .': '. $field->getError() .'</div>'; endif; ?>
                <?php $contador++;
                if($contador == 2) :?>
                  <div class="clear"></div> 
                  <?php $contador = 0; ?>
                <?php endif;?>                
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    <input type="hidden" value="<?php echo $mdObjectId; ?>" name="mdObjectId" />
    <div class="clear"></div>    
</form>
