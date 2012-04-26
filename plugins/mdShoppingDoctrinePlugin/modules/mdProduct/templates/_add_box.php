<div>
    <form action='<?php echo url_for('mdProduct/saveProduct'); ?>' method="post" id='product_new_form_'>
        <div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
            <?php //echo $form['mdAttributes']['mdAttributes_1']['mdProfileId']->render() ?>
            <?php //echo $form['id']->render() ?>
            <?php //echo $form['_csrf_token']->render() ?>
            <?php echo $form->renderHiddenFields()?>
            <?php include_partial('product_basic_info', array('form' => $form)) ?>

            <div style="float: right" id="md_object_save_cancel_button">
                <input type="button" onclick="MdProducts.getInstance().saveProfile();" value="<?php echo __('mdShoppingDoctrine_text_save') ?>"  />
                <input type="button" value="<?php echo __('mdShoppingDoctrine_text_cancel');?>" onclick="mastodontePlugin.UI.BackendBasic.getInstance().removeNew();" />
            </div>
        </div>
    <!--FIN ABIERTO TOP-->
    </form>
</div>

<script type="text/javascript">
    $(function() {
        $("input:button", "#md_object_save_cancel_button").button();
        $("a", "#md_object_delete").button();
    });
</script>