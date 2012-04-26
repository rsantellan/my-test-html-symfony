<?php use_helper('I18N') ?>
<div id="md_login_form">
<form action="<?php echo url_for('@signin') ?>" method="post">
<ul>
	<li><?php echo $form->renderHiddenFields()?></li>
	<li><?php echo $form['username']->renderLabel(__('mdAuthDoctrine_text_username'))?> <?php echo $form['username']->render()?> <?php echo $form['username']->renderError()?></li>
	<li><?php echo $form['password']->renderLabel(__('mdAuthDoctrine_text_password'))?> <?php echo $form['password']->render()?> <?php echo $form['password']->renderError()?></li>
	<li><?php echo $form['remember']->renderLabel(__('mdAuthDoctrine_text_remember'))?> <?php echo $form['remember']->render()?> <?php echo $form['remember']->renderError()?></li>
  <li><?php echo $form->renderGlobalErrors()?></li>
	<li class="submit"><input type="submit" value="<?php echo __('mdAuthDoctrine_text_signIn') ?>" /></li>
</ul>

</form>

<?php if(!empty($exception)): ?>
<h3><?php echo $exception; ?></h3>
<?php endif; ?>
</div>
