<?php
slot('mdContact', true);
use_helper('mdAsset');
?>
<!--left start-->
<div class="left">
  <h2><span class="black"><?php echo __("contacto_titulo izquierdo"); ?></span><span class="brown"><?php echo __("contacto_titulo derecho"); ?></span></h2>
  <?php if($form->hasGlobalErrors()) : ?>
  
  <?php endif; ?>
  <?php if($sf_user->hasFlash("mdContactSend")): ?>
	<?php
	  $flash = $sf_user->getFlash("mdContactSend");
	  if($flash == true):
	?>
	  <?php echo __("contacto_mail enviado con exito"); ?>
	         
	  <?php else: ?>
		<?php echo __("contacto_mail no enviado con exito"); ?>
	  <?php endif; ?>
  <?php else: ?>
<!--  <h2><span class="black"><?php echo __("contacto_titulo izquierdo"); ?></span><span class="brown"><?php echo __("contacto_titulo derecho"); ?></span></h2>-->
  <form name="<?php echo $form->getName(); ?>" method="POST" action="<?php echo url_for('@mdContact') ?>" class="contacto">
	<label for="<?php echo $form['nombre']->renderId() ?>" class="blue">
	  <?php echo __('contacto_nombre'); ?>
	</label>
	<?php if ($form['nombre']->hasError()): ?>
  	<label class="error">(<?php echo $form['nombre']->getError(); ?>)</label>
	<?php endif; ?>
	<br class="spacer" />
	<?php echo $form['nombre']->render(array("size" => 50)) ?>
	<br class="spacer" />
	<label for="<?php echo $form['mail']->renderId() ?>" class="blue"><?php echo __('contacto_email'); ?></label>
	<?php if ($form['mail']->hasError()): ?>
  	<label class="error">(<?php echo $form['mail']->getError(); ?>)</label>
	<?php endif; ?>
	<br class="spacer" />
	<?php echo $form['mail']->render(array("size" => 50)) ?> 
	<br class="spacer" />
	<label for="<?php echo $form['telefono']->renderId() ?>" class="blue"><?php echo __('contacto_telefono'); ?></label>
	<?php if ($form['telefono']->hasError()): ?>
  	<label class="error">(<?php echo $form['telefono']->getError(); ?>)</label>
	<?php endif; ?>
	<br class="spacer" />
	<?php echo $form['telefono']->render(array("size" => 50)) ?>
	<br class="spacer" />
	<label for="<?php echo $form['comentario']->renderId() ?>" class="blue"><?php echo __('contacto_comentario'); ?></label>
	<?php if ($form['comentario']->hasError()): ?>
  	<label class="error">(<?php echo $form['comentario']->getError(); ?>)</label>
	<?php endif; ?>
	<br class="spacer" />		
	<?php echo $form['comentario']->render(array("rows" => "5", "cols" => "40")) ?>
	<br class="spacer" />		
	<input type="submit" value="<?php echo __('contacto_enviar'); ?>" class="button no_float" />
	<?php echo $form->renderHiddenFields() ?>
  </form>
  <?php endif; ?>
  <br class="spacer" />
</div>
<!--left end-->

<?php //echo $form->renderGlobalErrors() ?>
    
