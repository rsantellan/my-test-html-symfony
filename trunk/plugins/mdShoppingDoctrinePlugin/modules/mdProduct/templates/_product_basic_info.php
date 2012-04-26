<?php

$mdCurrency = doctrine::getTable('mdCurrency')->find($form['md_currency_id']->getValue());

?>
<div id="md_basic_<?php echo $form->getObject()->getId() ?>" class="md_open_object_top">
    <div class="md_blocks">
        <h2><?php echo $form[$sf_user->getCulture()]['name']->renderLabelName();?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form[$sf_user->getCulture()]['name']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form[$sf_user->getCulture()]['name']->render(array('id'=>'md_input_name')); ?>
        </div>
        <div><?php if($form[$sf_user->getCulture()]['name']->hasError()): echo $form[$sf_user->getCulture()]['name']->renderLabelName() .': '. $form[$sf_user->getCulture()]['name']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks">
        <h2><?php echo $form['is_public']->renderLabelName();?>: </h2>
        <?php if(!$form->getObject()->isNew()):?>
        	<input type="checkbox" <?php if($form->getObject()->getIsPublic()) echo 'CHECKED'; ?> name="<?php echo $form['is_public']->renderName(); ?>" />
    	<?php else:?>
    		<?php echo $form['is_public']->render(); ?>
        <?php endif;?>
    </div>
    <?php if(1 == sfConfig::get('sf_multiple_product', 0)):?>
    <div class="md_blocks">
        <h2><?php echo $form['is_multiple']->renderLabelName();?>: </h2>
        <?php if(!$form->getObject()->isNew()):?>
        	<input type="checkbox" <?php if($form->getObject()->getIsMultiple()) echo 'CHECKED'; ?> onclick="changeProductMultiple(<?php echo $form->getObject()->getId()?>)"/>
    	<?php else:?>
    		<?php echo $form['is_multiple']->render(); ?>
        <?php endif;?>
    </div>
    <?php endif;?>
    <div class="clear"></div>
    <div class="md_blocks">
        <h2><?php echo $form['price']->renderLabelName();?></h2>

        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['price']->hasError()): ?>error_msg<?php endif; ?>">
            <label><?php echo $mdCurrency->getSymbol()?></label>
            <?php echo $form['price']->render(array('class'=>'md_input_short')) ?>
        </div>
        
        <div style="<?php if( sfConfig::get( 'sf_plugins_shopping_show_tax', false ) ) echo "display:none;"; ?>float: left; padding: 2px; margin: 2px;" class="<?php if($form['tax']->hasError()): ?>error_msg<?php endif; ?>">
            <label class="md_open_object_top"><?php echo $form['tax']->renderLabelName();?></label>
            <?php echo $form['tax']->render(array('class'=>'md_input_short')); ?>
            <label>%</label>
        </div>
        
        <div><?php if($form['price']->hasError()): echo $form['price']->renderLabelName() .': '. $form['price']->getError(); endif; ?></div>
        <?php if( sfConfig::get( 'sf_plugins_shopping_show_tax', false ) ): ?>
        <div><?php if($form['tax']->hasError()): echo $form['tax']->renderLabelName() .': '. $form['tax']->getError(); endif; ?></div>
        <?php endif;?>
    </div>
    <div class="md_blocks">
        <h2><?php echo $form['quantity']->renderLabelName();?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['quantity']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['quantity']->render(array('class'=>'md_input_short')); ?>
        </div>
        <?php $mdUnits = $form->getObject()->getPosibleUnits(); ?>
        <?php if(count($mdUnits) == 1): ?>
            <?php echo $mdUnits[0]->getName();?>
            <input type="hidden" name="<?php echo $form['md_unit_id']->renderName(); ?>" value="<?php echo $mdUnits[0]->getId();?>"/>
        <?php else: ?>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['md_unit_id']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['md_unit_id']->render(); ?>
        </div>
        <?php endif; ?>
        <div class="clear"></div>
        <div><?php if($form['md_unit_id']->hasError()): echo $form['md_unit_id']->getError(); endif; ?></div>
        <div><?php if($form['quantity']->hasError()): echo $form['quantity']->renderLabelName() .': '. $form['quantity']->getError(); endif; ?></div>
    </div>
    <div class="clear"></div>
    
    <div class="md_blocks" style="<?php if( sfConfig::get( 'sf_plugins_shopping_show_weight', true ) ) echo "display:none;"; ?>">
        <h2><?php echo $form['weight']->renderLabelName();?>(Kg): </h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['weight']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['weight']->render(); ?>
        </div>
        <div><?php if($form['weight']->hasError()): echo $form['weight']->renderLabelName() .': '. $form['weight']->getError();  endif; ?></div>
    </div>
    <div class="md_blocks" style="<?php if( sfConfig::get( 'sf_plugins_shopping_show_weight', true ) ) echo "display:none;"; ?>">    
        <h2><?php echo $form['volumetric_weight']->renderLabelName();?>: </h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['volumetric_weight']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['volumetric_weight']->render(); ?>
        </div>
        <div><?php if($form['volumetric_weight']->hasError()): echo $form['volumetric_weight']->renderLabelName() .': '. $form['volumetric_weight']->getError();  endif; ?></div>        
    </div>
    
    
    <div class="clear"></div>
  <?php
    $show_attributes = true;
    if(isset($attributes_disable))  $show_attributes = false; 
  ?>

    <!--ATRIBUTOS-->
      <?php foreach($form['mdAttributes'] as $mdAttForm):?>
        <?php foreach($mdAttForm as $field): ?>
          <?php if(!$field->isHidden()): ?>
            <div class="md_blocks">
                <h2><?php echo $field->renderLabelName();?></h2>
                <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($field->hasError()):?>error_msg<?php endif; ?>">
                    <?php echo $field->render()?>
                </div>
                <div>
                    <?php if($field->hasError()):  echo $field->renderLabelName() .': '. $field->getError(); endif; ?>
                </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      <?php endforeach; ?>
        <!--FIN ATRIBUTOS-->
        
</div>
<!--FIN ABIERTO TOP-->
