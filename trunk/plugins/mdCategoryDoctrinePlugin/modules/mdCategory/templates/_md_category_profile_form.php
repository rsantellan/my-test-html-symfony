<?php use_helper( 'JavascriptBase' );?>
<form id="md_dynamic_new_profile_<?php echo $mdProfileId; ?>" action="<?php echo url_for('mdCategory/saveProfileAjax'); ?>" method="post" onsubmit="return saveProfileAjax(<?php echo $mdProfileId; ?>, <?php echo $mdObjectId; ?>);" class="profile_form">
  <?php echo $form->renderHiddenFields() ?>

  <?php include_partial('md_category_profile', array('form'=>$form,'name'=> $name, 'mdProfileId' => $mdProfileId, 'mdObjectId' => $mdObjectId )) ?>
  <input type="hidden" value="<?php echo $mdObjectId; ?>" name="mdObjectId" />
  <div class="clear"></div>    
</form>
