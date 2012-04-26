<?php
        include_component('uploader', 'uploader', array(
      'upload_url'        => url_for('@mdImageFileGalleryUpload?' . ini_get('session.name') . '=' . session_id() . '&upload=mastodonte'), //ruta al action que procesa la imagen y la sube
      'file_types'        => sfConfig::get('sf_plugins_upload_content_type_image_gallery', '*.jpg;*.jpeg;*.gif;*.png'),  //formatos soportados
      'max_filesize'      => 'upload_max_filesize',       //peso en bites máximo para cada imagen
      'file_upload_limit' => 0,                           //cantidad de archivos máximo que podemos subir
      'file_queue_limit'  => 0,                           //
      'progress_style'    => 'swfupload-progressFile',    //javascript que dibuja el contenedor de imagenes subidas y thumbnails
      'post_params'       => '"h": 70,"w":70, "category":"' . $category . '"',            //altura y ancho que queremos mostrar el thumb de cada imagen
      'upload_browse'     => '<div id="image-browse" class="addbutton">' . __('mdMediaDoctrine_text_uploadFile') . '</div>',  //diseño que mostramos el boton de subir, debe mantenerse el id default
      'category'          => $category
    ))

?>
