<?php
use_helper('mdAsset');

use_plugin_javascript('mastodontePlugin', 'prototype');
use_plugin_javascript('mastodontePlugin', 'scriptaculous.js?load=effects,builder');
use_plugin_javascript('mdImageFileGalleryPlugin', 'lightbox');
use_plugin_stylesheet('mdImageFileGalleryPlugin', 'lightbox');

if($partialExists)
    include_partial($category);

slot($category,true);

?>
                <ul class="mdImageFileGalleryList">
<?php foreach($pager->getResults() as $image):?>
                    <li><a href="<?php echo mdWebImage::getUrl($image, array('width'=>600,'height'=>800));?>" rel="lightbox[roadtrip]"><img src="<?php echo mdWebImage::getUrl($image, array('height'=>120, 'crop'=>true))?>" width="160" height="120"></a></li>
<?php endforeach;?>
                </ul>

<?php if ($pager->haveToPaginate()): ?>
               <div id="paginado">
                    <a href="<?php echo url_for('@mdImageFileGallery?cat='.$category.'&page='.$pager->getPreviousPage()) ?>"> &lt; </a>
<?php
        $pagerCount = count($pager->getLinks());
        $pagerIndex = 0;
        foreach ($pager->getLinks() as $page):
            if ($page == $pager->getPage()): ?>
                        <a class="current"><?php echo $page ?></a>
        <?php else: ?>
                    <a href="<?php echo url_for('@mdImageFileGallery?cat='.$category.'&page='.$page) ?>"><?php echo $page ?></a>
        <?php endif;
            if($pagerIndex < $pagerCount -1){
                echo " | ";
            }
            $pagerIndex++;
        endforeach; ?>
                    <a href="<?php echo url_for('@mdImageFileGallery?cat='.$category.'&page='.$pager->getNextPage()) ?>"> > </a>
               </div>
<?php endif;?>
<?php


