<?php

/**
 * PluginmdMedia
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 6820 2009-11-30 17:27:49Z jwage $
 */
abstract class PluginmdMedia extends BasemdMedia
{
    const NO_IMAGE          = '/images/no_image.jpg';

    public static $default  = "default";

    public static $imageList    = array ('jpg', 'jpeg', 'gif', 'png', 'JPG', 'JPEG', 'GIF', 'PNG', 'pdf');

    public static $documentList = array ('pdf', 'doc', 'docx', 'xls', 'ppt', 'xlsx', 'pptx');

    public static $videoList = array ('avi', 'flv', 'mpg');

    //Metodos publicos

    public function preDelete($event)
    {
        Md_Cache::$_use_cache = false;
        $mdMediaAlbums = $this->getMdMediaAlbum();
        foreach ($mdMediaAlbums as $mdMediaAlbum)
        {
            $mdMediaAlbum->delete();
        }
        Md_Cache::$_use_cache = true;
    }

    /**
     * Crea un nuevo album dados su titulo y descripcion
     * @param <array> $options
     */
    public function createAlbum($options = array())
    {
        $mdMediaAlbum = new mdMediaAlbum();
        $mdMediaAlbum->setMdMediaId($this->getId());
        $mdMediaAlbum->setTitle($options['title']);
        $mdMediaAlbum->setDescription($options['description']);
        $mdMediaAlbum->setType($options['type']);
        $mdMediaAlbum->save();
        return $mdMediaAlbum;
    }

    //Elimina el album de nombre $album o de id $album
    public function removeAlbum($album)
    {

    }

    /**
     * Sube el contenido $mdObject al usuario $mdUser.
     * $options es un array con los valores de los contenidos y el album al cual subir
     * ejemplo: options = array('album' => 'vacaciones', 'typeAlbum' => 'Mixed', 'type' => 'png', 'filename' => 'foto_01.png', 'name' => 'fiesta')
     * Los datos del album son opcionales.
     *
     * @param <Object> $mdUser
     * @param <Object> $mdObject
     * @param <array> $options
     * @return <mdMediaContentConcrete>
     */
    public function upload($mdUser, $mdObject, $options)
    {
        if(!array_key_exists('album', $options) || $options['album'] == '' || (is_int($options['album']) && $options['album'] == 0))
        {
            //Obtenemos el album default
            $album = Doctrine::getTable('mdMediaAlbum')->retrieveAlbum($this->getId(), self::$default, 86400, Doctrine_Core::HYDRATE_RECORD);
            if(!$album)
            {
                $type = (!array_key_exists('typeAlbum', $options) || $options['typeAlbum'] == '') ? mdMediaAlbum::MIXED : $options['typeAlbum'];
                $optionsAlbum = array('title' => self::$default, 'description' => 'Este es el album por defecto', 'type' => $type);
                $album = $this->createAlbum($optionsAlbum);
            }

        }
        else
        {
            //Obtenemos el album
            $album = Doctrine::getTable('mdMediaAlbum')->retrieveAlbum($this->getId(), $options['album'], 86400, Doctrine_Core::HYDRATE_RECORD);
            if(!$album)
            {
                throw new Exception('The album ' . $options['album'] . ' not exist', 100);
            }
        }

        try
        {
            $mdMediaContentConcrete = NULL;
            if(in_array($options['type'], self::$documentList))
            {
                $mdMediaContentConcrete = new mdMediaFile();
                $mdMediaContentConcrete->setFiletype($options['type']);
            }
            elseif(in_array($options['type'], self::$videoList))
            {
                $mdMediaContentConcrete = new mdMediaVideo();
                $mdMediaContentConcrete->setType($options['type']);
                $mdMediaContentConcrete->setAvatar("");
                $mdMediaContentConcrete->setDuration("1:00:00");
            }
            elseif(in_array($options['type'], self::$imageList))
            {
                $mdMediaContentConcrete = new mdMediaImage();
            }
            else
            {
                throw new Exception('PluginmdMedia::upload - type not supported ' . $options['type'], 100);
            }

            //Seteamos los atributos
            $mdMediaContentConcrete->setFilename($options['filename']);
            $mdMediaContentConcrete->setName($options['name']);
            $mdMediaContentConcrete->setMdUserIdTmp($mdUser->getId());
            $mdMediaContentConcrete->setPath($mdObject->getPath());

            $mdMediaContentConcrete->save();

            $album->addContent($mdMediaContentConcrete);

            return $mdMediaContentConcrete;

        }catch(Exception $e){

            throw $e;

        }
    }

    /**
     * Devuelve true si tiene el album, false en caso contrario
     * Puede recibir tanto identificador del album como el titulo del mismo
     *
     * @param <integer | string> $album
     */
    public function hasAlbum($album)
    {
        return (Doctrine::getTable('mdMediaAlbum')->retrieveAlbum($this->getId(), $album) !== false);
    }

    //Metodos de consultas

    /**
     * Devuelve todos los albums del mdMedia de tipo $key
     * @param <enum [Image,Video,File,Mixed]> $key
     * @return <array>
     */
    public function retrieveAlbums($key = mdMediaManager::MIXED, $hydrationMode = Doctrine_Core::HYDRATE_ARRAY)
    {
        return Doctrine::getTable('mdMediaAlbum')->findAlbums($this->getId(), $key, 86400, $hydrationMode);
    }
}
