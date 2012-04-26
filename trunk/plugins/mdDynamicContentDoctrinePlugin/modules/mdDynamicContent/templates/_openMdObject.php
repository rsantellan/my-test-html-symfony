<div ajax-url="<?php echo url_for('mdDynamicContent/closedBox?id='.$form->getObject()->getId()) ?>">
  <?php use_helper('mdAsset') ?>
  <li class="md_objects open" id='md_object_<?php echo $form->getObject()->getId() ?>'>
      <div id="show_error"></div>
      <?php include_partial('mdDynamicContent/md_object_basic_info', array('form' => $form)) ?>
      <div id="start_profiles" class="start_profiles">
          <div class="clear"></div>
          <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
          <?php
          foreach($profiles as $prof):?>

              <?php $profForm = $form->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
              <?php include_partial('mdDynamicContent/profile_form', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdObjectId' => $form->getObject()->getId() )) ?>

          <?php endforeach;?>
      </div>
      <div class="clear"></div>
      <div id="news_extra_info">
        
          <?php if( sfConfig::get( 'sf_plugins_dynamic_feature', false ) ):  ?>
            <?php 
              $use_feature = true;
              if( sfConfig::get( 'sf_plugins_dynamic_feature_filtered', false ) )
              {
                $use_feature = false;
                
                foreach($profiles as $prof)
                {
                  if( sfConfig::get( 'sf_plugins_dynamic_feature_filtered_profile_'.$prof->getMdProfile()->getId(), false ) )
                  {
                    $use_feature = true;
                  }
                }
              }
              ?>
              <?php if($use_feature): ?>
                <?php include_component('mdFeaturesBox','loadFeatureBox', array('object_id'=> $form->getObject()->getId(),'object_class' => $form->getObject()->getObjectClass()));?>
                <div class="clear"></div>
              <?php endif; ?>
          <?php endif; ?>
                        
          <?php if( sfConfig::get( 'sf_plugins_dynamic_category', false ) ):  ?>
            <?php 
              $use_category = true;
              if( sfConfig::get( 'sf_plugins_dynamic_category_filtered', false ) )
              {
                $use_category = false;
                foreach($profiles as $prof)
                {
                  if( sfConfig::get( 'sf_plugins_dynamic_category_filtered_profile_'.$prof->getMdProfile()->getId(), false ) )
                  {
                    $use_category = true;
                  }
                }
              }
              ?>
              <?php if($use_category): ?>          
                <?php include_component('mdCategoryObject', 'objectRelationBox', array('mdObject'=>$form->getObject()));?>
              <?php endif; ?>
          
          <?php endif;?>

          <?php if( sfConfig::get( 'sf_plugins_dynamic_media', false ) ):  ?>
            <?php 
              $use_media = true;
              if( sfConfig::get( 'sf_plugins_dynamic_media_filtered', false ) )
              {
                $use_media = false;
                foreach($profiles as $prof)
                {
                  if( sfConfig::get( 'sf_plugins_dynamic_media_filtered_profile_'.$prof->getMdProfile()->getId(), false ) )
                  {
                    $use_media = true;
                  }
                }
              }
              ?>
              <?php if($use_media): ?>
                <div id="user_images">
                    <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $form->getObject())) ?>
                </div>
              <?php endif; ?>
          <?php endif; ?>
      </div>
      <div class="clear"></div>


      <?php if( sfConfig::get('sf_plugins_relation_content_manage', false)): ?>
        <?php include_component('mdRelationContent','relationContent', array('_MD_Content_Id' => $form->getObject()->retrieveMdContent()->getId(), '_MD_Object_Id' => $form->getObject()->getId(), '_MD_Object_Class_Name' => $form->getObject()->getObjectClass(), '_MD_Dynamic_Content_Type' => $form->getObject()->getTypeName())); ?>
        <br/>
      <?php endif; ?>

      <?php if( sfConfig::get('sf_plugins_dynamic_googleMap_manage', false) && sfConfig::get('sf_plugins_dynamic_googleMap_' . $form->getObject()->getTypeName(), false) ): ?>
        <?php include_partial('mdMap/googleMap', array('object' => $form->getObject(), 'options' => array('width' => 538, 'height' => 400))); ?>
      <?php endif; ?>

      <div class="bloques">
          <?php if( sfConfig::get( 'sf_plugins_category_attributes', false ) && sfConfig::get( 'sf_plugins_category_attribute_addProfiles', false ) ):  ?>
              <?php include_partial('newProfileBox/add_profile', array('id' => $form->getObject()->getId(), 'class' => $form->getObject()->getObjectClass())); ?>
          <?php endif;?>

          <div class="clear"></div>
          <div class="md_blocks" id="md_object_delete">
              <a id="delete_object" href="<?php echo url_for('mdDynamicContent/deleteMdContentAjax') ?>" onclick="return mdDynamicContent.getInstance().deleteMdObjectWithConfirmation(<?php echo $form->getObject()->getId() ?>, '<?php echo __("mdDynamicContentDoctrine_text_confirmRemove");?>');"><?php echo __('mdDynamicContentDoctrine_text_delete');?></a>
          </div>

          <div style="float: right" id="md_object_save_cancel_button">
              <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="mdDynamicContent.getInstance().saveMdProfileByAjax(<?php echo $form->getObject()->getId()?>);"/>
              <input type="button" value="<?php echo __('mdDynamicContentDoctrine_text_cancel');?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();" />
          </div>
          <div class="clear"></div>
      </div>

  </li><!--LI PRODUCTO A EDITAR-->
</div>
<script type="text/javascript">
    $(function() {
      $( "input:button", "#md_object_save_cancel_button" ).button();
      $( "a", "#md_object_delete" ).button();
    });
</script>
