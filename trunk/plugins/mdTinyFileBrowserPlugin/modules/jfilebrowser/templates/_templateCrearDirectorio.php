<h3 class="titulo2"><?php echo __('mdFileBrowserTiny_text_crearDirectorio'); ?></h3>
<form id="form12" action="/backend.php/jfilebrowser/crearDirectorio" method="post" enctype="multipart/form-data" name="form12" onsubmit="crearDirectorio(this); return false;">
  <table border="0" cellspacing="0" cellpadding="0" class="princip">
    <tr>
      <td valign="top" class="log_in_label"><?php echo __('mdFileBrowserTiny_text_directorio'); ?></td>
      <td class="log_in_field"><input name="nombre" type="text" id="nombre" value="" size="35" /></td>
    </tr>
    <tr>
      <td colspan="2" class="enviar_td">
        <input name="enviar3" type="submit" id="enviar3" value="<?php echo __('mdFileBrowserTiny_text_enviar'); ?>" />
      </td>
    </tr>
  </table>
</form>