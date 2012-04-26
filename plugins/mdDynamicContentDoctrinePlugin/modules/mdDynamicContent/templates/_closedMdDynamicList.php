<ul id="objects" class="md_objects">
    <li style="display: none;" id="new_md_object_"></li>
    <?php $module = 'mdDynamicContent'; ?>
    <?php foreach ($pager->getResults() as $md_object): ?>
    
    <?php include_partial($module.'/closedMdContent', array('md_object' => $md_object)) ?>
        <script type="text/javascript">
            createMdObjectBox(<?php echo $md_object->getId() ?>);
        </script>
    <?php endforeach; ?>

    <?php if ($pager->haveToPaginate()): ?>
            <div id="md_pager">
        <?php echo link_to('<', 'mdDynamicContent/index?page=' . $pager->getPreviousPage()) ?>
        <?php $pagerCount = count($pager->getLinks()) ?>
        <?php $pagerIndex = 0 ?>
        <?php foreach ($pager->getLinks() as $page): ?>
        <?php if ($page == $pager->getPage()): ?>
                    <a class="current"><?php echo $page ?></a>
        <?php else: ?>
                        <a href="<?php echo url_for('mdDynamicContent/index?page=' . $page) ?>"><?php echo $page ?></a>
        <?php endif; ?>
        <?php
                        if ($pagerIndex < $pagerCount - 1) {
                            echo " | ";
                            $pagerIndex++;
                        }
        ?>
        <?php endforeach; ?>
        <?php echo link_to('>', 'mdDynamicContent/index?page=' . $pager->getNextPage()) ?>
                    </div>
    <?php endif; ?>



</ul>
