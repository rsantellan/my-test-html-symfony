<?php
	use_javascript('jquery-1.6.4.min.js', 'first');
	use_javascript('fancybox/jquery.fancybox-1.3.1.pack.js','last');
	use_stylesheet('../js/fancybox/jquery.fancybox-1.3.1.css');
	use_javascript("location.js", 'last');
    slot('locations', ':D');
?>
<?php foreach($locales as $local): ?>
    <div class="local_container">
        <?php include_partial("localInfo", array("local" => $local, 'sf_cache_key' => "nat_local_".$local->getId()));?>
    </div>
<?php endforeach; ?>

<div class="clear"></div>
<div id="caja4">
  <p>&nbsp;</p>
  <h1>PLANTA INDUSTRIAL</h1>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p align="left" line-height="150%">
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dir.:</strong>
    </font>
    <font color="#000000" font size="-6"> Colonia Suiza – Picada Benitez Km 23,5</font>
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel:</strong>
    </font>
    <font color="#000000" font size="-6"> (+598) 4554 7138</font> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horario Administración:</strong>
    </font>
    <font color="#000000" font size="-6"> 8 a 16hs.</font>
  </p>
  <p align="left">
    <font color="#009900" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripción:</strong>
    </font>
    <font color="#000000" font size="-6"> Quesos con tradición</font>
  </p>
</div>

<div id="caja5">
  <p>&nbsp;</p>
  <h1>LOCAL COLONIA</h1>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p align="left" line-height="150%">
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dir.:</strong>
    </font>
    <font color="#000000" font size="-6">Gral Flores 437 </font>
    <br/>
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel:</strong>
    </font>
    <font color="#000000" font size="-6"> (+598) 4522 5215</font> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horario Administración:</strong>
    </font>
    <font color="#000000" font size="-6"> 8 a 20hs.</font>
  </p>
  <p align="left">
    <font color="#009900" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripción:</strong>
    </font>
    <font color="#000000" font size="-6">Venta al publico minorista</font>
  </p>
</div>


<div id="caja6">
  <p>&nbsp;</p>
  <h1>LOCAL MONTEVIDEO</h1>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p>&nbsp;</p>
  <p align="left" line-height="150%">
    <font color="#FF0000" font size="-4">
      <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Dir.:</strong>
    </font>
    <font color="#000000" font size="-6">Blvar Artigas 3750 </font>
    <br/>
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Tel:</strong>
    </font>
    <font color="#000000" font size="-6"> (+598) 2204 2029</font> 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <font color="#FF0000" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Horario Administración:</strong>
    </font>
    <font color="#000000" font size="-6"> 8 a 20hs.</font>
  </p>
  <p align="left">
    <font color="#009900" font size="-4">
    <strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Descripción:</strong>
    </font>
    <font color="#000000" font size="-6">Centro de distribución y venta al público</font>
  </p>
</div>
