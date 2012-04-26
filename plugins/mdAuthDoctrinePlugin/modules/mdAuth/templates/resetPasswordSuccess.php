<form action="<?php echo url_for('@resetPassword') ?>" method="post" id="form_reset_password_ajax">
<ul>
  <li>
    Le enviaremos sus datos de login a su casilla de mail
  </li>
  <li>
    <?php echo $form['email']->render(array('value'=>'Email')); ?><?php echo $form['email']->renderError(); ?>
    <?php echo $form['_csrf_token']->render(); ?>
  </li>
  <li>
    <?php if(isset ($exception)): ?>
    <?php print_r($exception); ?>
    <?php endif; ?>
  </li>
  <li>
    <div class="float_right">
      <input type="submit" value="enviar clave">
    </div>
    <div class="clear"></div>
  </li>
</ul>
</form>
