<?php if ($pager->haveToPaginate()): ?>
    <div id="md_pager">
        <?php echo link_to('<', 'mdProduct/index?page='.$pager->getPreviousPage()) ?>
        <?php $pagerCount = count($pager->getLinks())?>
        <?php $pagerIndex = 0?>
        <?php foreach ($pager->getLinks() as $page): ?>
            <?php if ($page == $pager->getPage()): ?>
                <a class="current"><?php echo $page ?></a>
            <?php else: ?>
            <a href="<?php echo url_for('mdProduct/index?page='.$page) ?>"><?php echo $page ?></a>
            <?php endif; ?>
            <?php
                if($pagerIndex < $pagerCount -1)
                {
                    echo " | ";
                    $pagerIndex++;
                }
            ?>
        <?php endforeach; ?>
        <?php echo link_to('>', 'mdProduct/index?page='.$pager->getNextPage()) ?>
    </div>
<?php endif;?>