<?php

/**
 * jfilebrowser actions.
 *
 * @package    homero-de-leon
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class jfilebrowserActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    //Pido albums

    //Pido directorios
    $directorios = array();
    $directorios = jfilebrowser::directoryList();

    return $this->renderText($this->getPartial('index', array('directorios' => $directorios)));
  }

  public function executeVerCategoria(sfWebRequest $request)
  {
    $name = $request->getParameter('id');
    $view = $request->getParameter('view', 'thumbnails');

    $archivos = jfilebrowser::getFiles($name);

    $this->pager = new mdArrayPager(null, sfConfig::get('app_mdImageFileGallery_list_pagerSize',30));
    $this->pager->setResultArray($images);
    $this->pager->setPage($this->getRequestParameter('page',1));
    $this->pager->init();

    return $this->renderText($this->getPartial('verCategoria', array('id' => $name, 'view' => $view, 'archivos' => $archivos)));
  }

  public function executeBuscar(sfWebRequest $request)
  {
    //TO DO
    return $this->renderText(json_encode(array('response' => 'ok')));
  }

  public function executeCrearDirectorio(sfWebRequest $request)
  {
    try
    {
        $name = $request->getParameter('nombre');
        if($name == '')
        {
            throw new Exception('nombreVacio', 100);
        }
        $name = ereg_replace("[^A-Za-z0-9]", "", $name);
        jfilebrowser::createDirectory($name);

        $directorios = jfilebrowser::directoryList();

        return $this->renderText(json_encode(array('response' => 'OK', 'content' => $this->getPartial('index', array('directorios' => $directorios)))));
    }
    catch(Exception $e)
    {
        //TO DO
        //manejar codigo de exepciones para mostrar mensaje adecuado
        return $this->renderText(json_encode(array('response' => 'ERROR', 'content' => $e->getMessage())));
    }
  }

  public function executeBorrarDirectorio(sfWebRequest $request)
  {
    try
    {
        $name = $request->getParameter('nombre');
        if($name == '')
        {
            throw new Exception('nombreVacio', 100);
        }

        jfilebrowser::deleteDirectory($name);

        $directorios = jfilebrowser::directoryList();

        return $this->renderText(json_encode(array('response' => 'OK', 'content' => $this->getPartial('index', array('directorios' => $directorios)))));
    }
    catch(Exception $e)
    {
        //TO DO
        //manejar codigo de exepciones para mostrar mensaje adecuado
        return $this->renderText(json_encode(array('response' => 'ERROR', 'content' => $e->getMessage())));
    }
  }

  public function executeBorrarArchivo(sfWebRequest $request)
  {
    try
    {
        $name = $request->getParameter('name');
        $directorio = $request->getParameter('directorio');
        $view = $request->getParameter('view');

        jfilebrowser::deleteFile($directorio, $name);

        $archivos = jfilebrowser::getFiles($directorio);

        return $this->renderText(json_encode(array('response' => 'OK', 'content' => $this->getPartial('verCategoria', array('archivos' => $archivos, 'id' => $directorio, 'view' => $view)))));
    }
    catch(Exception $e)
    {
        //TO DO
        //manejar codigo de exepciones para mostrar mensaje adecuado
        return $this->renderText(json_encode(array('response' => 'ERROR', 'content' => $e->getMessage())));
    }
  }

  public function executeTemplateCrearDirectorio(sfWebRequest $request)
  {
    return $this->renderText($this->getPartial( 'templateCrearDirectorio', array() ));
  }

  public function executeTemplateSubirArchivo(sfWebRequest $request)
  {
    //Pido directorios
    $directorios = array();
    $directorios = jfilebrowser::directoryList();

    return $this->renderText($this->getPartial( 'templateSubirArchivo', array('directorios' => $directorios) ));
  }

  public function executeSubirArchivo(sfWebRequest $request)
  {
    try
    {

    }
    catch (Exception $e)
    {
        //TO DO
        //manejar codigo de exepciones para mostrar mensaje adecuado
        return $this->renderText(json_encode(array('response' => 'ERROR', 'content' => $e->getMessage())));
    }
  }

  public function executeTemplateView(sfWebRequest $request)
  {
    try
    {
        $name = $request->getParameter('name');
        $directorio = $request->getParameter('directorio');

        $archivo = jfilebrowser::find($directorio, $name);

        return $this->renderText(json_encode(array('response' => 'OK', 'content' => $this->getPartial('templateView', array('archivo' => $archivo, 'directorio' => $directorio)))));
    }
    catch(Exception $e)
    {
        //TO DO
        //manejar codigo de exepciones para mostrar mensaje adecuado
        return $this->renderText(json_encode(array('response' => 'ERROR', 'content' => $e->getMessage())));
    }
  }

  public function executeGetUrl(sfWebRequest $request)
  {
      $ancho = $request->getParameter('width');
      $alto = $request->getParameter('height');
      $directorio = $request->getParameter('directory');
      $name = $request->getParameter('name');

      $archivo = jfilebrowser::find($directorio, $name);

      $path = mdWebImage::getUrl($archivo->getRouteWithOutPath(), array('width' => $ancho, 'height' => $alto));
      sfContext::getInstance()->getLogger()->err("<<<<<!!!! este es el path: ".$path);
      $path = str_replace("/backend.php","",$path);
      return $this->renderText($path);
  }

}
