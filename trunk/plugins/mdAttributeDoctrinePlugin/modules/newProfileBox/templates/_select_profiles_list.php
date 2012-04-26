<form id="show_form_profile_<?php echo $objectId; ?>" action="<?php echo url_for('newProfileBox/showProfileAjax'); ?>" method="post" onsubmit="return showProfile('<?php echo $objectId; ?>');" >
  <span>Seleccionar un perfil</span>
  <div class="clear"></div>
  <?php use_helper( 'JavascriptBase' );?>
  <?php echo javascript_tag("showProfile('".$objectId."');"); ?>
    <div id="list_profiles_<?php echo $objectId; ?>">
        <?php include_partial('list_profiles', array('objectId' => $objectId ,'mdProfiles' => $mdProfiles)); ?>
    </div>
    <input type="hidden" name="objectId" value="<?php echo $objectId; ?>" />
    <input type="hidden" name="objectClass" value="<?php echo $objectClass; ?>" />
    <div id="profile_form_<?php echo $objectId; ?>"></div>
</form>
