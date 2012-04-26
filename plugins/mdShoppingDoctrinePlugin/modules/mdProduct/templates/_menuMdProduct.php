<?php if(sfContext::getInstance()->getRouting()->hasRouteName('mdProducts') && !sfConfig::get('sf_plugins_products_manage')): ?>

    <li><a href="<?php echo url_for('@mdProducts')?>" class="<?php if(has_slot('mdProducts')){ echo 'current'; } else { echo ''; } ?>"><?php echo __('backendLayout_Productos') ?></a></li>

<?php else: ?>
    <li>
            <ul class="dropdown">
        	<li><a href="Javascript:void(0)"><?php echo __('backendLayout_Productos') ?></a>
                    <ul class="sub_menu">
                        <?php
                        $mdProfiles = MdProductHandler::retrieveAllUsableMdProfile();

                        foreach($mdProfiles as $profile): ?>

                            <li><a href="<?php echo url_for('@mdProducts?typeName=' . $profile->getName())?>" class="<?php if(has_slot('mdProducts_'.$profile->getName())){ echo 'current'; } ?>"><?php echo __('backendLayout_text_backendProduct' . $profile->getName());?></a></li>

                        <?php endforeach;?>
                    </ul>
                </li>
            </ul>
            <?php  use_helper('JavascriptBase');?>
            <?php echo javascript_tag("
                $(function(){

                $('ul.dropdown li').hover(function(){
                    $(this).addClass('hover');
                    $('ul:first',this).css('visibility', 'visible');

                }, function(){

                    $(this).removeClass('hover');
                    $('ul:first',this).css('visibility', 'hidden');

                });

                $('ul.dropdown li ul li:has(ul)').find('a:first').append(' &raquo; ');

                });
            ");?>
     </li>
<?php endif; ?>


