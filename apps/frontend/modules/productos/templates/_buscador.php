<div class="search">
  <span class="topCurve"></span>
  <form class="searchForm" name="form1" method="GET" action="<?php echo url_for("@buscar");?>">
    
	<h2><span><?php echo __("productos_buscador");?></span></h2>
	<input type="text" value="" name="n" />
	<input type="submit" value="<?php echo __("productos_buscar");?>" class="button" />					
	<br class="spacer" />     
  </form> 
  <span class="bottomCurve"></span>
</div>
