<p>Elija el album para subir la imagen</p>

<?php $values = array(); ?>
<?php foreach($albums as $album): ?>
<?php $values[$album->getId()] =  $album->getTitle(); ?>
<?php endforeach; ?>

<?php $m = new sfWidgetFormChoice(array('choices' => $values)); ?>

<?php echo $m->render('album'); ?>
<br />