<?php
/*
 * Clase para manejo del mdImageFileGallery
 * Galería de imagenes por archivo
 */

/**
 *
 *
 * @author     maui
 */
DEFINE('MDIMAGEFILEGALLERY_PATH', sfConfig::get('app_mdImageFileGallery_path', sfConfig::get('sf_upload_dir') . '/mdImageFileGallery'));

class mdImageFileGallery {

    const PATH = MDIMAGEFILEGALLERY_PATH;


    static public function getImagesByDate($options = array()){
        return MdFileHandler::getListByDate(self::getPathFromOptions($options));
    }

    static public function getCategories($options = array()){
        return MdFileHandler::getFolders(self::getPathFromOptions($options));
    }



    /*
     * options
     *  [path]                       | carpeta donde se buscaran las imagenes
     *  [absolute] => false          | si esta opcion es true se usara la opcion [path] absolutamente, false usa siempre la ruta por defecto como base y la opcion[path] como directorio
     */
    static private function getPathFromOptions($options){

        if(!isset($options['path'])){
            $path = self::PATH;
        }else{
            $path = $options['path'];
        }

        if (isset($options['path']) AND isset($options['absolute']) AND $options['absolute'] === false)
            $path = MdFileHandler::checkPathFormat(self::PATH) . $path;

        $path = MdFileHandler::checkPathFormat($path);

        return $path;
    }

    
}