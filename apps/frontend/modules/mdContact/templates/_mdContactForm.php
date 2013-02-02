<?php
slot('mdContact', true);
use_helper('mdAsset');
?>

<h1>Contacto</h1>
    
<div id="caja1">

<form name="<?php echo $form->getName(); ?>" method="POST" action="<?php echo url_for('@mdContact') ?>" class="contacto">
    <p>
	<label for="<?php echo $form['nombre']->renderId() ?>" class="blue">
	  <?php echo __('contacto_nombre'); ?>
	</label>
	<?php if ($form['nombre']->hasError()): ?>
	    <label class="error">(<?php echo $form['nombre']->getError(); ?>)</label>
	<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $form['nombre']->render() ?>
    </p>
    <p>
	<label for="<?php echo $form['apellido']->renderId() ?>" class="blue">
	  <?php echo __('contacto_apellido'); ?>
	</label>
	<?php if ($form['apellido']->hasError()): ?>
	    <label class="error">(<?php echo $form['apellido']->getError(); ?>)</label>
	<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $form['apellido']->render() ?>
    </p>
    <p>
	<label for="<?php echo $form['mail']->renderId() ?>" class="blue">
	  <?php echo __('contacto_email'); ?>
	</label>
	<?php if ($form['mail']->hasError()): ?>
	    <label class="error">(<?php echo $form['mail']->getError(); ?>)</label>
	<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $form['mail']->render() ?>
    </p>
    <p>
	<label for="<?php echo $form['asunto']->renderId() ?>" class="blue">
	  <?php echo __('contacto_asunto'); ?>
	</label>
	<?php if ($form['asunto']->hasError()): ?>
	    <label class="error">(<?php echo $form['asunto']->getError(); ?>)</label>
	<?php endif; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	<?php echo $form['asunto']->render() ?>
    </p>
    <p>&nbsp;</p>
    <p>
	<label for="<?php echo $form['comentario']->renderId() ?>" class="blue"><?php echo __('contacto_comentario'); ?></label>
	<?php if ($form['comentario']->hasError()): ?>
  	<label class="error">(<?php echo $form['comentario']->getError(); ?>)</label>
	<?php endif; ?>
    </p>
    <p>
	<?php echo $form['comentario']->render(array("rows" => "5", "cols" => "40")) ?>
    </p>
    <p>
	<input type="submit" value="<?php echo __('contacto_enviar'); ?>" class="button no_float" />
	<?php echo $form->renderHiddenFields() ?>
    </p>
</form>
</div>

<div id="caja2">
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>&nbsp;</p>
	<p>
	    <a href="https://www.facebook.com/GranjaNaturalia">
		<?php echo image_tag("logo-face.jpg", array("width" => 53, "height"=>53)); ?>
	    </a>
	</p>
	<p>&nbsp;</p>
	<!-- <p><a href="https://twitter.com/"><img src="imgs/logo-twitter.jpg" width="50" height="50" /></a></p> -->
	<p>&nbsp;</p>
</div>
