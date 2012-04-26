<?php if(sfContext::getInstance()->getRouting()->hasRouteName('mdDynamicContent') && !sfConfig::get('sf_plugins_dynamic_manage')): ?>

    <li><a href="<?php echo url_for('@mdDynamicContent')?>" class="<?php if(has_slot('mdDynamicContent')){ echo 'current'; } ?>"><?php echo __('mdDynamicContentDoctrine_text_backendTitle');?></a></li>

<?php else: ?>
    <?php
    $dynamicContents = contentHandler::getInstance()->retrieveDynamicParents();

    if(count($dynamicContents) == 1):
        $dynamicContent = $dynamicContents[0]; ?>

        <li><a href="<?php echo url_for('@mdDynamicContent?typeName=' . $dynamicContent["typeName"])?>" class="<?php if(has_slot('mdDynamicContent_'.$dynamicContent["typeName"])){ echo 'current'; } ?>"><?php echo __('mdDynamicContentDoctrine_text_backend' . $dynamicContent['typeName']);?></a></li>

    <?php else: ?>
        <li>
            <ul class="dropdown">
                <li><a href="Javascript:void(0)"><?php echo __('mdDynamicContentDoctrine_text_backendTitle');?></a>
                    <ul class="sub_menu">
                        <?php foreach($dynamicContents as $dynamicContent) : ?>

                            <li><a href="<?php echo url_for('@mdDynamicContent?typeName=' . $dynamicContent["typeName"])?>" class="<?php if(has_slot('mdDynamicContent_'.$dynamicContent["typeName"])){ echo 'current'; } ?>"><?php echo __('mdDynamicContentDoctrine_text_backend' . $dynamicContent['typeName']);?></a></li>

                        <?php endforeach;?>
                    </ul>
                </li>
            </ul>

            <?php use_helper('JavascriptBase'); ?>
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
                "); ?>
        </li>
    <?php endif; ?>
<?php endif; ?>
