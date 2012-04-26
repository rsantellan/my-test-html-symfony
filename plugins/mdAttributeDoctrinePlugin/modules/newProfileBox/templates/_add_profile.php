<?php $profiles = mdAttributeHandler::retrieveProfilesOfGivenClass($class); ?>
<?php if(count($profiles) > 1): ?>
<div class="clear"></div>
<div class=""><a href="javascript:void(0)" onclick="newProfileBox.getInstance().retrieveProfilesList('<?php echo $id; ?>','<?php echo $class; ?>','<?php echo url_for('newProfileBox/getProfiles')?>'); return false;"><?php echo __('mdAttributeDoctrine_text_addProfile');?></a></div>
    <div id="new_profile_<?php echo $id ?>" style="display:none"></div>
</div>

<div class="clear"></div>
<?php endif;?>
