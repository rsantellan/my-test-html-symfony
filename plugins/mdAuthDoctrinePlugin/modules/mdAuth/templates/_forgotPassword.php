
<div class="modal_bg">
    <div id="modal_center">
        <div class="cabezal">
            <h1 class="float_left"><?php echo __("usuario_Recordar contraseña");?></h1>
        </div>
        <div class="clear"></div>
        <div>
            <?php if($isAjax != "1"): ?>
              <form action="<?php echo url_for('@resetPassword') ?>" method="post" id="form_reset_password_ajax">
            <?php else: ?>
              <form action="<?php echo url_for('@forgotPasswordProcessAjax') ?>" method="post" id="form_reset_password_ajax" onsubmit="return forgotPasswordForm(this);">
            <?php endif; ?>
            
                <?php echo $form->renderHiddenFields();?>
                <ul>
                    <li>
                      <?php echo __("usuario_Le enviaremos sus datos de login a su casilla de mail");?>
                    </li>
                    <li>
                        <?php echo __("usuario_email");?>
                        <?php echo $form['email']->render(); ?>
                        <?php echo $form['email']->renderError(); ?>
                        
                    </li>
                    <li>
                        <?php if(isset ($exception)): ?>
                            <?php print_r($exception); ?>
                        <?php endif; ?>
                    </li>
                    <li>
                        <div class="float_right">
                            <input type="submit" value="<?php echo __("usuario_Enviar clave");?>">
                        </div>
                        <div class="clear"></div>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
