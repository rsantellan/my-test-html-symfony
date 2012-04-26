<div class="container_combo">
    <span><?php echo __("mdDynamicContentDoctrine_text_selectProfile"); ?></span>
    <div class="clear"></div>

    <?php if($mdProfiles->count() > 0): ?>
    <select id='new_profile_' name='mdProfileId' onchange="return mdDynamicContent.getInstance().showProfile();">
        <option value="0"></option>
        <?php foreach($mdProfiles as $mdProfile):?>
            <option value="<?php echo $mdProfile->getId()?>"><?php echo $mdProfile->getName(); ?></option>
        <?php endforeach;?>
    </select>
    <?php endif; ?>
</div>
