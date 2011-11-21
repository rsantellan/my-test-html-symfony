<?php
    $profile = mdProfileHandler::getInstance($local)->loadProfile('puntoVenta');
    $instance = mdMediaManager::getInstance(mdMediaManager::ALL, $local)->load(); 
    $avatar = null;
    if($instance->hasAlbum("default")):
        $avatar = $instance->getAvatar(NULL, true);
?>
<?php endif; ?>

<?php if(!is_null($avatar)): ?>
    <img src="<?php echo $avatar->getUrl(array(mdWebOptions::WIDTH => 65, mdWebOptions::HEIGHT => 65,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" alt="<?php echo $profile->getValue("nombre"); ?>" />
<?php else: ?>
    <label class="punto_venta_label"><?php echo $profile->getValue("nombre"); ?></label>
<?php endif; ?>