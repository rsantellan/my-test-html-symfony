<div class="modal_bg">
    <div id="modal_center">
        <div class="cabezal">
            <h1 class="float_left">Recordar contraseña</h1>
        </div>
        <div class="clear"></div>
        <div>
            <form action="<?php echo url_for('@changePassword') ?>" method="post" id="form_change_password_ajax">
                <ul>
                    <li>
                        Contraseña: <?php echo $form['password']->render(); ?><?php echo $form['password']->renderError(); ?>
                        <div class="clear"></div>
                        Repetir Contraseña: <?php echo $form['password_confirmation']->render(); ?><?php echo $form['password_confirmation']->renderError(); ?>
                        <?php echo $form->renderHiddenFields(); ?>
                    </li>
                    <li>
                        <div class="float_right">
                            <input type="submit" value="Cambiar" onclick="return sendChangePassword()">
                            <a href="javascript:void(0)" onclick="return cancelEditUser('<?php echo url_for('mdUserManagementFrontend/retrieveSmallInfo');?>')">Cancelar</a>
                        </div>
                        <div class="clear"></div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
