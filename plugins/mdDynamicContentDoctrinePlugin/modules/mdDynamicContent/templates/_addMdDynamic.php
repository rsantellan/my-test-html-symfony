<form action='<?php echo url_for('mdDynamicContent/createDynamicContent'); ?>' method="post" id='md_content_new_form_'>
    <?php include_partial('mdDynamicContent/mdContent_basic_info', array('form' => $form)); ?>
    <?php echo $form->renderHiddenFields()?>
    <div style="float: right" id="md_object_save_cancel_button">
        <input type="button" value="<?php echo __('mdUserDoctrine_text_save') ?>"  onclick="return mdDynamicContent.getInstance().saveMdContent('<?php echo url_for('mdDynamicContent/closedBox')?>');"/>
        <input type="button" value="<?php echo __('mdDynamicContentDoctrine_text_cancel');?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();" />
    </div>
    <div class="clear"></div>
</form>
<script type="text/javascript">
    $(function() {
      $( "input:button", "#md_object_save_cancel_button" ).button();
    });
</script>
