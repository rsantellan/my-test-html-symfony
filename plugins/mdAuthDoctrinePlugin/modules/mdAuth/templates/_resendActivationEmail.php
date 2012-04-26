<div class="modal_bg">
    <div id="modal_center">
        <div class="cabezal">
            <h1 class="float_left">Email de activacion</h1>
            <div class="close float_right"><a href="javascript:void(0)" >Cerrar</a></div>
        </div>
        <div class="clear"></div>
        <div>
            <form action="<?php echo url_for('@sendActivationEmail') ?>" method="post" id="form_resend_activation_email_ajax" onsubmit="return submitResendActivationEmailAjax()">
                <ul>
                    <li>
				Le enviaremos el link de activacion a su casilla de mail
                    </li>
                    <li>
                        <?php echo $form['email']->render(array('value'=>'Email')); ?><?php echo $form['email']->renderError(); ?>
                        <?php echo $form['md_application_id']->render(array('value'=>$sf_user->getMdApplication()->getId())); ?>
                        <?php echo $form['_csrf_token']->render(); ?><?php //echo $form['_csrf_token']->renderError(); ?>
                        <?php //echo $form->renderHiddenFields(); ?>
                    </li>
                    <li>
                        <div class="float_right">
                            <input type="submit" value="enviar clave">
                        </div>
                        <div class="clear"></div>
                    </li>
                    <li>
                        <a href="">loguerame</a>
                    </li>
                </ul>
            </form>
        </div>
    </div>
</div>
