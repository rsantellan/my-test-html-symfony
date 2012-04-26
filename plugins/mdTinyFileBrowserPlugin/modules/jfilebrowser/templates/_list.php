<?php if(count($archivos) > 0){ ?>
    <ul class="imag_list_ul_lista">

    <?php $i = 1; ?>
    <?php foreach($archivos as $archivo):
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
       } ?>

        <li>
            <div>
                <form id="form_<?php echo $i; ?>" class="form_submit_lista" method="post" action="/backend.php/jfilebrowser/borrarArchivo" class="centrar_2" onsubmit="jFileBrowserDialog.confirmar('<?php echo __('mdFileBrowserTiny_text_alertBorrarImagen'); ?>', '<?php echo $i; ?>'); return false">
                    <input type="hidden" name="directorio" value="<?php echo $directorio; ?>" />
                    <input type="hidden" name="name" value="<?php echo $archivo->getName(); ?>" />
                    <input type="hidden" name="view" value="list" />
                    <input type="image" name="borrar_cat_bt" id="borrar_cat_bt" src="img/delete.png" />
                </form>
                <a href="" title="<?php echo $archivo->getName(); ?>" class="archivos_mime_<?php echo $mime_t ?>"><?php echo $archivo->getName(); ?></a>
            </div>
        </li>
    <?php $i++; ?>
    <?php endforeach; ?>

    </ul>
<?php } else echo 'no se encontr&oacute; ning&uacute;n archivo'; ?>
