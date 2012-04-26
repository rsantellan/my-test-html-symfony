<?php
//swith para las clases de los tipo de archivos
switch($archivo->getExtension()){
    case 'jpg':
    case 'jpeg':
    case 'gif':
    case 'png':
            $mime_t = 'imagen';
        break;
    case 'pdf':
            $mime_t = 'pdf2';
        break;
    case 'doc':
    case 'docx':
            $mime_t = 'doc2';
        break;
    case 'xls':
    case 'xlsx':
            $mime_t = 'xls2';
        break;
    case 'ppt':
    case 'pptx':
            $mime_t = 'ppt2';
        break;
    default: $mime_t = 'gen2';
}

//tipos de archivos
$tipo_arch = ($mime_t == 'imagen') ? 1 : 2;
$path = mdWebImage::getUrl($archivo->getRouteWithOutPath(), array('width' => 350, 'height' => 250));
?>

<div class="archiv_indiv_dv">
    <a href="" title="<?php echo $archivo->getName(); ?>" target="_blank">
    <?php if($mime_t == 'imagen') {?>
    <img src="<?php echo $path; ?>" width="250" height="150" alt="<?php echo $archivo->getName(); ?>" />
    <?php } else { ?>
    <img src="img/<?php echo $mime_t ?>.png" alt="" />
    <?php } ?>
    </a>

    <div class="centrar"><?php echo $archivo->getName(); ?></div>
</div>

<form id="jfileImageForm" name="jfileImageForm" class="centrar" method="post" action="" onsubmit="jFileBrowserDialog.insert();return false;">
    <input type="hidden" id="jfilebrowser_directorio" name="directorio" value="<?php echo $directorio; ?>">
    <input type="hidden" id="jfilebrowser_path" name="path" value="<?php echo $path; ?>">
    <input type="hidden" id="jfilebrowser_type" name="type" value="<?php echo $tipo_arch; ?>">
    <input type="hidden" id="jfilebrowser_title" name="title" value="<?php echo $archivo->getName(); ?>">

    <label><?php echo __('mdFileBrowserTiny_textoAlternativo'); ?></label>
    <input type="text" id="jfilebrowser_alt" name="alt">
    <div style="clear:both"></div>

    <label><?php echo __('mdFileBrowserTiny_alineacion'); ?></label>
    <input type="radio" name="align" id="none" value="none" checked="checked" />
    <label class="label_radio align_none"><?php echo __('mdFileBrowserTiny_ninguna'); ?></label>
    <input type="radio" name="align" id="left" value="left" />
    <label class="label_radio align_left"><?php echo __('mdFileBrowserTiny_izquierda'); ?></label>
    <div style="clear:both"></div>
    <label>&nbsp;</label>
    <input type="radio" name="align" id="center" value="center" />
    <label class="label_radio align_center"><?php echo __('mdFileBrowserTiny_centrar'); ?></label>
    <input type="radio" name="align" id="right" value="right" />
    <label class="label_radio align_right"><?php echo __('mdFileBrowserTiny_derecha'); ?></label>
    <div style="clear:both"></div>    

    <label><?php echo __('mdFileBrowserTiny_tamano'); ?></label>
    <label class="label_chico"><?php echo __('mdFileBrowserTiny_ancho'); ?></label>
    <input class="input_chico" type="text" id="jfilebrowser_ancho" name="ancho">
    <label class="label_chico label_chico_margin">x <?php echo __('mdFileBrowserTiny_alto'); ?></label>
    <input class="input_chico" type="text" id="jfilebrowser_alto" name="alto">
    <div style="clear: both;"></div>

    <input type="submit" name="insertar" id="insertar" value="Insertar" style="width: 100px;"/>
</form>

