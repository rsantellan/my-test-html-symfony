<ul class="md_categories">
<?php
if(!isset($level)) $level = 0;
while($tree):
?>
    <li class="md_category_level_<?php echo $level;?>"><?php echo $tree->mdCategory->getName();?>
    <?php if ($tree->son == null):?>
     <div class="md_category_remove" style="display: none;" onclick="return mdCategoryObjectBox.removeCategoryObject(<?php echo $mdObject->getId();?>, <?php echo $tree->mdCategory->getId()?>,this);"></div>
    <?php endif; ?>
    </li>
<?php
    if ($tree->son != null):?>
    <li>
        <?php include_partial('mdCategoryObject/objectRelationBoxTreeNode',array('tree'=>$tree->son, 'mdObject' => $mdObject,'level'=>$level+1));?>
    </li>
<?php
    endif;
    $tree = $tree->brother;
endwhile;
?>
</ul>
