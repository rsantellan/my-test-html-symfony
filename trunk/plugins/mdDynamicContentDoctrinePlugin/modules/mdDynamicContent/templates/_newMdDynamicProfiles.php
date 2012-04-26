<?php
/**
 * Recibe:
 * un array con los perfiles a mostrar en $mdProfiles
 * el id del usuario en $mdUserId, este se usa unicamente para identificar el DIV
 */
?>
<form id="show_new_form_profile" action="<?php echo url_for('mdDynamicContent/showProfileAjax'); ?>" method="post" onsubmit="return mdDynamicContent.getInstance().showProfile();" >

    <?php if($mdProfiles->count() > 0): ?>

        <div id="list_profiles_<?php echo $mdUserId; ?>">
            <?php include_partial('mdDynamicContent/listProfiles', array('mdProfiles' => $mdProfiles)); ?>
        </div>

    <?php else: ?>

        <input type="hidden" name="mdProfileId" value="0" />
        <script type="text/javascript">showProfile();</script>

    <?php endif; ?>

    <div id="profile_form_"></div>
</form>
