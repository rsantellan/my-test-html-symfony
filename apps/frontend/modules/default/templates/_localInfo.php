<?php $profile = mdProfileHandler::getInstance($local)->loadProfile('locales');?>
<br class="spacer" />
<div class="left1">
    <div class="testimonials">
        <h1 class="smallBlack"><span class="black2"><?php echo $profile->getValue("nombre"); ?></span></h1>
        <?php 
            $instance = mdMediaManager::getInstance(mdMediaManager::ALL, $local)->load(); 
            
            if($instance->hasAlbum("default")):
                $avatar = $instance->getAvatar(NULL, true);
                if(!is_null($avatar)):
            ?>
        <div class="blueBg">
            <div class="blueBgText">
                <p><?php echo __("locales_ver galeria");?></p>		
            </div>
            
            <div class="blueBgPic">
                <a class="grouped_images" rel="group<?php echo $local->getId();?>" href="<?php echo $avatar->getUrl(array(mdWebOptions::WIDTH => 640, mdWebOptions::HEIGHT => 480,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" title="" >
                    <img src="<?php echo $avatar->getUrl(array(mdWebOptions::WIDTH => 300, mdWebOptions::HEIGHT => 200,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" alt="" />
                </a>
            </div>
            <div class="hidden"> 
                <?php foreach($instance->getItems() as $item): ?>
                    <?php if($item->getId() != $avatar->getId() ): ?>
                        <a class="grouped_images" rel="group<?php echo $local->getId();?>" href="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 640, mdWebOptions::HEIGHT => 480,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" title="" >
                            <img src="<?php echo $item->getUrl(array(mdWebOptions::WIDTH => 300, mdWebOptions::HEIGHT => 200,  mdWebOptions::CODE => mdWebCodes::CROPRESIZE)); ?>" alt="" />
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php endif; ?>
    </div>
    <div class="services">
        <h2 class="smallBlack"><span class="black2"><?php echo __("locales_Datos:");?></span></h2>
        <ul>
            <li><strong><?php echo __("locales_Direccion:");?></strong><span><?php echo $profile->getValue("direccion"); ?></span></li>
            <li><strong><?php echo __("locales_Telefono:");?></strong><span><?php echo $profile->getValue("telefono"); ?></span></li>
            <li><strong><?php echo __("locales_Horario:");?></strong><span><?php echo $profile->getValue("horario"); ?></span></li>                
            <li><strong class="description"><?php echo __("locales_Descripcion:");?></strong><span><?php echo $profile->getValue("descripcionLocal"); ?></span></li> 
        </ul><br class="spacer" />
    </div>
</div>
<br class="spacer" />
