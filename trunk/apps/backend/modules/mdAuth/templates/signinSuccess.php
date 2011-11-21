<?php use_helper('I18N') ?>
<div id="wrapper">
    <div id="header"></div>
    <div class="container">
        <div id="topcorners"><div class="cleft"></div><div class="cright"></div></div>
        <div id="content">
            <form action="<?php echo url_for('@signin') ?>" method="post">
                <table class="login" style="margin-left: auto; margin-right: auto;">
                    <tbody>
                        <tr>
                            <td>
                                <p class="mtop0 mbottom025">
                                    <strong><?php echo $form['username']->renderLabel(__('mdAuthDoctrine_text_username')) ?></strong>
                                </p>
                                <?php echo $form['username']->render(array('class' => "inputtext", 'tabindex' => "1")) ?>
                                <?php echo $form['username']->renderError() ?>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="mtop0 mbottom025">
                                    <strong><?php echo $form['password']->renderLabel(__('mdAuthDoctrine_text_password')) ?></strong>
                                </p>
                                <?php echo $form['password']->render(array('class' => "inputtext", 'tabindex' => "2")) ?>
                                <?php echo $form['password']->renderError() ?>
                            </td>
                        </tr>

                        <tr>
                            <td>
                                <p class="mtop025 mbottom0">
                                    <?php echo $form['remember']->render(array('tabindex' => "3")) ?>
                                    <?php echo $form['remember']->renderLabel(__('mdAuthDoctrine_text_remember')) ?>
                                    
                                </p>
                                <?php echo $form['remember']->renderError() ?>
                            </td>
                            
                        </tr>


                        <tr>
                            <td style="padding-top: 10px;">
                                <input class="bprimarypub80" tabindex="4" value="<?php echo __('mdAuthDoctrine_text_signIn') ?>" type="submit"/>
                            </td>
                        </tr>
                        <tr><?php echo $form->renderHiddenFields() ?></tr>
                    </tbody>
                </table>
            </form>
            <?php if (!empty($exception)): ?>
                <h3><?php echo $exception; ?></h3>
            <?php endif; ?>
            <?php echo $form->renderGlobalErrors(); ?>
        </div>
        <div id="bottomcorners"><div class="cleft"></div><div class="cright"></div></div>
    </div>
</div>
