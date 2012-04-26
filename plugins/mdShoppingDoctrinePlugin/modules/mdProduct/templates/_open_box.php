<div ajax-url="<?php echo url_for('mdProduct/closedBox?id='.$form->getObject()->getId()) ?>">
    <ul class="md_objects" >
        <li class="md_objects open" id='md_object_<?php echo $form->getObject()->getId() ?>'>
            <form action='<?php echo url_for('mdProduct/saveProduct'); ?>' onsubmit="MdProducts.getInstance().saveEdit(this); return false;" method="post" id='product_edit_form_<?php echo $form->getObject()->getId() ?>'>
                <?php
                    echo $form['id']->render();
                    echo $form['md_currency_id']->render();
                    //echo $form['mdAttributes']['mdAttributes_1']['mdProfileId']->render();
                    echo $form['_csrf_token']->render();
                    //echo $form[$sf_user->getCulture()]['id']->render();
                    //echo $form[$sf_user->getCulture()]['lang']->render();
                ?>

                <?php include_partial('product_basic_info', array('form' => $form)); ?>
            </form>
            <div id="start_profiles" class="start_profiles">
                  <div class="clear"></div>
                  <?php $profiles = $form->getObject()->getAllUsedProfiles();?>
                  <?php
                  foreach($profiles as $prof):?>

                      <?php $profForm = $form->getObject()->getAttributesFormOfMdProfile($prof->getMdProfile()->getName()); ?>
                      <?php include_partial('profile_form', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdObjectId' => $form->getObject()->getId() )) ?>

                  <?php endforeach;?>
              </div>
                <div id="product_extra_info">

                    <?php if( sfConfig::get( 'sf_plugins_shopping_media', false ) ):  ?>
                        <div id="user_images" class="md_object_images">
                            <?php include_component('mdMediaContentAdmin', 'showAlbums', array('object' => $form->getObject())) ?>
                        </div>
                    <?php endif;?><!--IMAGENES PRODUCTO-->

                  <?php include_component('mdCategoryObject', 'objectRelationBox', array('mdObject'=>$form->getObject()));?>
                  <?php if(1 == sfConfig::get('sf_multiple_product', 0)):?>
                  <?php include_component('mdProduct', 'MdProductMultiple', array('mdObject'=>$form->getObject()));?>
                  <?php endif;?>
                </div>
                <div class="float_left">
                    <a id="delete_product" href="<?php echo url_for('mdProduct/deleteProduct') ?>" onclick="MdProducts.getInstance().deleteProductWithConfirmation('<?php echo __("mdProductDoctrine_text_confirmRemove")?>',<?php echo $form->getObject()->getId() ?>); return false;"><?php echo __('mdProductDoctrine_text_delete');?></a>
                </div>
                <div class="buttons_holder" style="float: right">
                    <input type="button" value="<?php echo __('mdProductDoctrine_text_save') ?>" onclick="MdProducts.getInstance().saveEdit(<?php echo $form->getObject()->getId()?>);"/>
                    <input type="button" onclick="mastodontePlugin.UI.BackendBasic.getInstance().close();" value="<?php echo __('mdProductDoctrine_text_cancel') ?>" />
                </div>
            
        </li>
    </ul>

</div>
<script type="text/javascript">
    $(function() {
		$( "input:button", ".buttons_holder" ).button();
    });
</script>