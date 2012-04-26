<div style="height: 51px; margin: 4px;" ajax-url="<?php echo url_for('mdProduct/openBox?id='.$object->getId()) ?>">
    <input type="hidden" name="_MD_OBJECT_ID" value="<?php echo $object->getId(); ?>" />
    <input type="hidden" name="_MD_OBJECT_CLASS_NAME" value="<?php echo $object->getObjectClass(); ?>" />
    <ul class="md_closed_object">
        <li class="md_height_fixed close" id="md_object_<?php echo $object->getId() ?>">
            <ul class="md_closed_object">
                <li class="md_img">
                    <img id="product_<?php echo $object->getId()?>" src="<?php echo $object->retrieveAvatar(array(mdWebOptions::WIDTH => 46, mdWebOptions::HEIGHT => 46,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" />
                </li>

                <li class="md_object_name">
                  <?php echo html_entity_decode( $object->getBackendClosedBoxText()); ?>
                </li>
            </ul>
        </li>
    </ul>

</div>
