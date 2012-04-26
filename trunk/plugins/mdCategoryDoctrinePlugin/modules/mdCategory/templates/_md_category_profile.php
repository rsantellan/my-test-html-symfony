<?php foreach($form as $field): ?>
    <?php if(!$field->isHidden()): ?>
      <div class="md_blocks">
          <h2><?php echo $field->renderLabelName();?></h2>
          <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
              <?php echo $field->render()?>
          </div>
          <div><?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?></div>
      </div>
    <div class="clear"></div>
    <?php endif; ?>
<?php endforeach; ?>
