<?php use_helper('mdAsset'); ?>
<?php use_plugin_javascript('mdCommentsDoctrinePlugin', 'mdCommentsManager.js');?>
<div id="addMdDynamicRelation">
    <p style="margin:20px 0px 20px 0px;"><?php echo __('mdDynamicContent_text_createDynamic'); ?></p>

    <form action='<?php echo url_for('mdDynamicContent/createDynamicContentRelation'); ?>' method="post" id='md_content_new_form_'>
        <input type="hidden" name="_MD_Object_Class_Name" value="<?php echo $_MD_Content_Concrete_Owner->getObjectClass(); ?>" />
        <input type="hidden" name="_MD_Object_Id" value="<?php echo $_MD_Content_Concrete_Owner->getId(); ?>" />

        <?php echo $form->renderHiddenFields()?>

        <?php include_partial('mdDynamicContent/mdContent_basic_info', array('form' => $form)); ?>

        <div style="float: right" id="md_object_save_cancel_button">
            <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="return mdDynamicContent.getInstance().saveMdContent('','_MD_RELATION');" />
            <input type="button" value="<?php echo __('mdDynamicContentDoctrine_text_cancel');?>" onclick="parent.$('#dialog-modal').dialog('close');" />
        </div>
        <div class="clear"></div>
    </form>
</div>
<script type="text/javascript">
    $(function() {
      $( "input:button", "#md_object_save_cancel_button" ).button();
    });
</script>
