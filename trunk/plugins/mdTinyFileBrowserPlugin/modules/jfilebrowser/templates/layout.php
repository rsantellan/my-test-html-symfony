<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>{#jfilebrowser_dlg.title}</title>
<link rel="stylesheet" type="text/css" href="css/style1.css" />
<script type="text/javascript" src="../../tiny_mce_popup.js"></script>
<script type="text/javascript" src="js/dialog.js"></script>
<script type="text/javascript" src="js/prototype.js"></script>
<script type="text/javascript" src="js/functions.js"></script>
</head>
<body>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="container_tb">
  <tr>
    <td class="col_1_td" valign="top"><table width="100%" border="0" cellpadding="0" cellspacing="0" class="menu_tb">
        <tr>
          <td><a href="index.php" title="Directorios"><img src="img/1244128462_folder_images.png" alt="" width="48" height="48" /></a></td>
        </tr>
        <tr>
          <td><a href="javascript:void(0)" onclick="verSubirArchivo();" title="Subir archivos"><img src="img/1246627152_Stock Index Up.png" alt="" width="48" height="48" /></a></td>
        </tr>
      </table>
    </td>
    <td valign="top">
        <div class="container_contenid_div">
            <?php //require_once '_busqueda.php'; ?>

            <h2 class="titulo1">File Browser</h2>

            <div class="bredcrum"></div>

            <div id="mensaje_error2" <?php if($error == '') { echo 'style="display:none"'; } ?>><?php echo $error; ?></div>

            <div id="container_tinyPlugin"></div>
        </div>
    </td>
  </tr>
</table>

<form onsubmit="jFileBrowserDialog.insert();return false;" action="#">
  <div class="mceActionPanel">
    <div style="float: left">
    </div>
    <div style="float: right">
      <input type="button" id="cancel" name="cancel" value="{#cancel}" onclick="tinyMCEPopup.close();" />
    </div>
  </div>
</form>
    <script type="text/javascript">
    <?php if(isset($_REQUEST['uploadFile'])): ?>
    Event.observe(window, 'load', function() {init('/backend.php/jfilebrowser/verCategoria?id=<?php echo $directorio; ?>');});
    <?php else: ?>
    Event.observe(window, 'load', function() {init();});
    <?php endif; ?>
    </script>
</body>
</html>