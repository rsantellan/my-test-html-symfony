<form action="<?php echo url_for("oneWidgetForms/saveSingleForm");?>" method="post" class="one_widget_form">
    <?php echo $form->renderHiddenFields();?>
    <?php
      $render = array();
      //$renderParameters = array();
      $showLabel = true;
      $widgetLabel = $form['widget']->renderLabel();
      if(isset($label))
      {
        $widgetLabel = $label;
      }
      if(isset($hideLabel))
      {
        $showLabel = false;
      }
      
      if(isset($renderParameters))
      {
        $render = $renderParameters->getRawValue();
      }
      else
      {
        if(isset($isOnChange) && $isOnChange)
        {
          $render["onChange"] = 'submitSingleAttributeForm(this)';
        }
        else
        {
          $render["onblur"] = 'submitSingleAttributeForm(this)';
        }
        
        $render["id"] = 'one_attribute_form_widget_'.$attributeId;
      }
    ?>
    <?php if($showLabel): ?>
      <?php if(isset($label)) : ?>
        <?php echo html_entity_decode($widgetLabel);?>
      <?php else: ?>
        <?php echo $widgetLabel;?>
      <?php endif; ?>
    <?php endif; ?>
    <?php echo $form['widget']->render($render); ?>
    <?php echo $form['widget']->renderError();?>
</form>
