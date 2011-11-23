<?php 
    slot('productos',':D'); 
    foreach($mySlots as $auxSlot)
    {
        slot($auxSlot, ':D');
    }
    
?>

<!--left start-->
<div class="left">
    
    
    <br class="spacer" />
    <ul class="product_list">
    
	<?php foreach($pager->getResults() as $producto): ?>  
        <?php include_partial("productoSmallInfo", array("producto" => $producto, "slug" => $category->getSlug(), 'sf_cache_key' => $producto->getId())); ?>
    <?php endforeach; ?>
    </ul>
	
	
	<?php if ($pager->haveToPaginate()): ?>
	  <br class="spacer" />
	  <div class="paginador">
		<?php if(!$pager->isFirstPage()): ?>
		  <a class="last_page_paginador" href="<?php echo url_for('categorias', $category)."?page=".$pager->getPreviousPage();?>" title="<?php echo __("producto_ANTERIOR");?>"><?php echo __("producto_ANTERIOR");?></a>
		<?php endif; ?>
		  
<!--		<?php //$pagerCount = count($pager->getLinks()) ?>
		<?php //$pagerIndex = 0 ?>
		<?php //foreach ($pager->getLinks() as $page): ?>
		<?php //if ($page == $pager->getPage()): ?>
			  <a class="current"><?php //echo $page ?></a>
		<?php //else: ?>
			  <a href="<?php //echo url_for('categorias', $category)."?page=". $page ?>" ><?php //decho $page ?></a>
		<?php //endif; ?>
		<?php //endforeach; ?>  -->
		  
		<?php if(!$pager->isLastPage()): ?>
		  <a class="next_page_paginador" href="<?php echo url_for('categorias', $category)."?page=".$pager->getNextPage();?>" title="<?php echo __("producto_SIGUIENTE");?>"><?php echo __("producto_SIGUIENTE");?>
		<?php endif; ?>
	  </div>
	<?php endif;?>
	
</div>
<!--left end-->

