<?php
$profile = mdProfileHandler::getInstance($categoria)->loadProfile('categorias');
?>
<div style="float:left !important; width: 352px !important; padding-right: 10px !important;">
<p align="left">
    <font size="2"font color="#FF0000" font face="Trebuchet MS, Arial, Helvetica, sans-serif">
        <b><?php echo $categoria->getName();?> -</b>
    </font>
    <font color="#000000">
        
    <b><?php echo $profile->getValue("descripcion"); ?></b>
    <br/>
    <ul> 
        <?php foreach($categoria->getSonsCategories() as $child): ?>
            <li><?php echo $child->getName();?></li>
        <?php endforeach; ?>
    </ul>
    </font>
</p>
</div>
