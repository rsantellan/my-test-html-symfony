<?php slot('quienesSomos',':D') ?>

<!--left start-->
<div class="left">
  <h2><span class="black"><?php echo __("quienesSomos_titulo izquierdo");?></span><span class="brown"><?php echo __("quienesSomos_titulo derecho");?></span></h2>
	<div class="buttons_containers">
    <div class="facebook">
      <div id="fb-root"></div><script src="http://connect.facebook.net/en_US/all.js#appId=170247116382784&amp;xfbml=1"></script><fb:like href="<?php echo $sf_request->getUri(); ?>" send="false" layout="button_count" width="120" show_faces="false" font=""></fb:like>
    </div>
    <div class="twitter">
      <a href="http://twitter.com/share" class="twitter-share-button" data-count="horizontal">Tweet</a>
      <script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script>
    </div>
    
    <div class="gplusone">
      <g:plusone size="medium" href="<?php echo $sf_request->getUri(); ?>"></g:plusone>
    </div>
  </div>
  <br class="spacer" />
  <p class="darkgrey">
            <?php
                echo __("quienesSomos_texto");
            ?>
	</p>
</div>
<!--left end-->

