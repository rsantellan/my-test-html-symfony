
<?php use_helper('JavascriptBase');?>
        <?php
            echo $form->renderHiddenFields();
        ?>        
    <div class="md_blocks">
        <h2><?php echo __('mdCategoryDoctrine_text_name'); ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form[$sf_user->getCulture()]['name']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form[$sf_user->getCulture()]['name']->render(array('id'=>'md_category_name')); ?>
        </div>
        <div><?php if($form[$sf_user->getCulture()]['name']->hasError()): echo $form[$sf_user->getCulture()]['name']->renderLabelName() .': '. $form[$sf_user->getCulture()]['name']->getError();  endif; ?></div>
    </div>
    <?php if(!$form['md_category_parent_id']->isHidden()): ?>
    <div class="md_blocks">
        <h2><?php echo __('mdCategoryDoctrine_text_parentName'); ?></h2>
        <div style="float: left; padding: 2px; margin: 2px;" class="<?php if($form['md_category_parent_id']->hasError()):?>error_msg<?php endif; ?>">
            <?php echo $form['md_category_parent_id']->render(array('id' => 'md_category_md_category_parent_id')); ?>
        </div>
        <div><?php if($form['md_category_parent_id']->hasError()): echo $form['md_category_parent_id']->renderLabelName() .': '. $form['md_category_parent_id']->getError();  endif; ?></div>
    </div>
    <?php endif;?>
    <div class="clear"></div>


    <?php if( sfConfig::get( 'sf_plugins_category_attributes_showLabel', false ) && !$form->getObject()->isNew()):  ?>
        <div class="md_blocks">
            <h2><?php echo __('mdCategoryDoctrine_text_helpShowLabel'); ?></h2>
            <div style="border:solid 1px red; padding: 5px; width: 120px;"><?php echo $form->getObject()->getLabel(); ?></div>
        </div>
        <div class="clear"></div>
    <?php endif; ?>


