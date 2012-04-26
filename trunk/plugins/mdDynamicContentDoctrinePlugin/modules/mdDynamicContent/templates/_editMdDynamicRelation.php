<?php use_helper('mdAsset') ?>
<p style="margin:20px 0px 20px 0px;"><?php echo __('mdDynamicContent_text_createDynamic'); ?></p>

<div id="show_error"></div>

<?php include_partial('mdDynamicContent/md_object_basic_info', array('form' => $form)) ?>
<div id="start_profiles" class="start_profiles">
  <div class="clear"></div>
  <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
  <?php $profiles_ids = array();?>
  <?php foreach($profiles as $prof):?>
      <?php array_push($profiles_ids, $prof->getMdProfile()->getId());?>
      <?php $profForm = $form->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
      <?php include_partial('mdDynamicContent/profile_form', array('form' => $profForm, 'name' => $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdObjectId' => $form->getObject()->getId() )) ?>

  <?php endforeach;?>
</div>
<div class="clear"></div>

<div id="news_extra_info">
  <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) && sfConfig::get( 'sf_plugins_dynamic_category_related', false )):  ?>
      <?php include_component('mdCategoryObject', 'objectRelationBox', array('mdObject' => $form->getObject()));?>
  <?php endif;?>

  <?php if( sfConfig::get( 'sf_plugins_dynamic_media', false ) ):  ?>
      <div id="user_images">
          <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $form->getObject())) ?>
      </div>
  <?php endif; ?>
  
  <?php if( sfConfig::get( 'sf_plugins_dynamic_backend_comments', false ) ):  ?>
    <?php 
      $setting_enable = false; 
      foreach($profiles_ids as $id)
      {
        $config = "sf_plugins_dynamic_backend_comments_profile_".$id;
        if( sfConfig::get( $config, false ))
        {
          $setting_enable = true; 
        }
      }
    ?>
    <?php if($setting_enable): ?>
      <div class="clear"></div>
      <h2>Listado de comentarios</h2>
      <?php
        use_plugin_javascript('mastodontePlugin', 'mdLoadController.js');
        use_plugin_javascript('mdCommentsDoctrinePlugin', 'mdCommentsManager.js'); 
      ?>
      <?php include_component('comment', 'list', array('object' => $form->getObject())); ?>
      <?php include_component('comment', 'formComment', array('object' => $form->getObject())); ?>
    <?php endif; ?>
  <?php endif; ?>
</div>
<div class="clear"></div>

<?php if( sfConfig::get('sf_plugins_dynamic_googleMap_manage', false) && sfConfig::get('sf_plugins_dynamic_googleMap_' . $form->getObject()->getTypeName(), false) ): ?>
    <?php include_partial('mdMap/googleMap', array('object' => $form->getObject(), 'options' => array('width' => 538, 'height' => 400, 'zoom' => 10))); ?>
<?php endif; ?>

<div class="bloques">
  <div class="md_blocks" id="md_object_delete">
      <a id="delete_object" href="<?php echo url_for("mdRelationContent/removeContent?_MD_Object_Id=" . $form->getObject()->getId() . "&_MD_Object_Class_Name=" . $form->getObject()->getObjectClass() . "&_MD_Content_Id=" . $_MD_Content_Id_Owner); ?>" onclick="return mdDynamicContent.getInstance().deleteMdObjectWithConfirmation(<?php echo $form->getObject()->getId() ?>, '<?php echo __("mdDynamicContentDoctrine_text_confirmRemove");?>','_MD_REALTION');"><?php echo __('mdDynamicContentDoctrine_text_deleteContent');?></a>
  </div>

  <div style="float: right" id="md_object_save_cancel_button">
      <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="mdDynamicContent.getInstance().saveMdProfileByAjax(<?php echo $form->getObject()->getId()?>, '_MD_RELATION');"/>
      <input type="button" value="<?php echo __('mdDynamicContentDoctrine_text_cancel');?>" onclick="parent.$('#dialog-modal').dialog('close');" />
  </div>
  <div class="clear"></div>
</div>

<script type="text/javascript">
    $(function() {
        $( "input:button", "#md_object_save_cancel_button" ).button();
        $( "a", "#md_object_delete" ).button();
        if(typeof initializeLightBox == 'function'){
            initializeLightBox(<?php echo $form->getObject()->getId(); ?>, '<?php echo $form->getObject()->getObjectClass(); ?>', MdAvatarAdmin.getInstance().getDefaultAlbumId());
        }
    });
</script>
