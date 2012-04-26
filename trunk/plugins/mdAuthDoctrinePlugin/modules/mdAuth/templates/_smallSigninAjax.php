<?php 
    use_helper('I18N');
    use_helper('mdAsset');
    use_plugin_javascript('mdAuthDoctrinePlugin', 'Modules/jquery/mdAuthAjax.js');
?>
<div id="form_login_ajax_div" class ="ajaxSmallSignInForm">
<form action="<?php echo url_for('@procesSigninAjax') ?>" method="post" id="form_login_ajax">
 <?php echo $form->renderHiddenFields(); ?>
 <div class="col_3">
 	<div class="box_1">
     	<ul class="bhead">
         	<li><?php echo __("user_ingresar");?></li>
         </ul>
        	<div class="bcont">
                <?php echo $form['username']->renderError(); ?>
        		<label for="login_username"><?php echo __('mdAuth_text_username')?></label><?php echo $form['username']->render(); ?><div class="clear"></div>
                <?php echo $form['password']->renderError(); ?>
				<label for="login_password"><?php echo __('mdAuth_text_password')?></label><?php echo $form['password']->render(); ?><div class="clear"></div>
				<?php if(!empty($exception)): ?>
				<h3><?php echo $exception; ?></h3>
				<?php endif; ?>
			</div>
            <input id="button_sign_in" type="button" onclick="return submitSigninAjax()" value="<?php echo __("user_ingresar");?>" />
            <div id="loader_sign_in" style="display: none"><?php echo plugin_image_tag('mastodontePlugin',"md-ajax-loader.gif");?></div>
   </div>
 </div>
</form>
</div>

