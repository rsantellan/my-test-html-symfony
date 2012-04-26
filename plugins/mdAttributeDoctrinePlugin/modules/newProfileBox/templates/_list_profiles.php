<?php if(count($mdProfiles) > 0): ?>
<select id='new_profile_<?php echo $objectId; ?>' name='mdProfileId' onchange="newProfileBox.getInstance().showObjectProfile('<?php echo $objectId; ?>');">
    <option value="0"></option>
    <?php foreach($mdProfiles as $mdProfile):?>
        <option value="<?php echo $mdProfile->getId()?>"><?php echo $mdProfile->getName()?></option>
    <?php endforeach;?>
</select>
<?php endif; ?>
