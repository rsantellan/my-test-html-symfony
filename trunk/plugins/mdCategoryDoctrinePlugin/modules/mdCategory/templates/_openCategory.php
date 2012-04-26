<div ajax-url="<?php echo url_for('mdCategory/showClosedCategory?mdCategoryId='.$form->getObject()->getId()) ?>">
<li class="md_objects open" id='md_object_<?php echo $form->getObject()->getId() ?>'>

    <div id="show_error"></div>
		
    <form action='<?php echo url_for('mdCategory/editCategory'); ?>' method="post" id='product_edit_form_<?php echo $form->getObject()->getId() ?>'>

        <?php /** INFO BASICA DEL PRODUCTO **/ ?>
        <?php include_partial('category_info', array('form' => $form)); ?>
		</form>
    <?php /******************************/ ?>
  <?php if( sfConfig::get( 'sf_plugins_category_attributes', false ) ):  ?>
    <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
		<?php
		foreach($profiles as $prof):?>
  				<?php $profForm = $form->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
				<?php include_partial('md_category_profile_form', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdObjectId' => $form->getObject()->getId() ));?>
		<?php endforeach;?>
  <?php endif; ?>  

    <?php echo $form->renderGlobalErrors();?>
    
        <?php /** INFO EXTRA: IMAGES, CATEGORIAS **/ ?>
        <div id="product_extra_info">
          <?php if( sfConfig::get( 'sf_plugins_category_media', false ) ):  ?>
              <div id="user_images">
                <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $form->getObject())) ?>
              </div><!--IMAGENES-->
					<?php endif;?>
           
        </div>
        <?php /************************************/ ?>



    <div class="clear"></div>

    <div class="clear"></div>

    <div class="float_left" id="remove_object">
        <a id="md__delete_objectbox" href="<?php echo url_for('mdCategory/deleteCategory') ?>?id=<?php echo $form->getObject()->getId() ?>" onclick="return mdCategory.getInstance().deleteCategoryWithConfirmation('<?php echo __('mdCategoryDoctrine_text_confirmDelete'); ?>',<?php echo $form->getObject()->getId() ?>, this,<?php echo $form->getObject()->obtainRoot()->getId() ?>);"><?php echo __('mdCategoryDoctrine_text_delete'); ?></a>
    </div>
    
    <div style="float: right" class="md_object_save">
       <a href="javascript:void(0)" onclick="return mdCategory.getInstance().saveObject(<?php echo $form->getObject()->getId() ?>);"><?php echo __('mdCategoryDoctrine_text_save'); ?></a>
       <a class="md_cancel_button" href="javascript:void(0)" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();"><?php echo __('mdCategoryDoctrine_text_cancel'); ?></a>
    </div>
    <div class="clear"></div>

</li><!--LI PRODUCTO A EDITAR-->
</div>
<script type="text/javascript">
    $(function() {
      $( "a", ".md_object_save" ).button();
      $( "a", "#remove_object" ).button();
    });
</script>
