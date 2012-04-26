<div class="modal_bg">
    <div id="modal_center">
        <div class="clear"></div>
        <div>
            <form action="<?php echo url_for('@changeEmail') ?>" method="post" id="form_change_email_ajax">
                <ul>
                    <li>
                    E-mail actual: <?php echo $sf_user->getEmail();?>
                    </li>
                    <li>
                        Nuevo Email: <?php echo $form['email']->render(); ?><?php echo $form['email']->renderError(); ?>
                        <?php echo $form->renderHiddenFields(); ?>
                    </li>
                    <li>
                        <div class="float_right">
                            <input type="button" value="enviar clave" onclick="sendChangeEmail()">
                            <a href="javascript:void(0)" onclick="return cancelEditUser('<?php echo url_for('mdUserManagementFrontend/retrieveSmallInfo');?>')">Cancelar</a>
                        </div>
                        <div class="clear"></div>
                    </li>

                </ul>
            </form>
        </div>
    </div>
</div>