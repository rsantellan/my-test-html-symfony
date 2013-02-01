<?php

/**
 * default actions.
 *
 * @package    default
 * @subpackage default
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class defaultActions extends sfActions
{
    public function postExecute()
    {
        mdMetaTagsHandler::addGenericMetas($this, null, array());
    }
    
    public function executeIndex(sfWebRequest $request)
    {
        $params = array();
        mdMetaTagsHandler::addMetas($this,'Inicio', array('params'=>$params));
    }
    
    public function executeLocation(sfWebRequest $request)
    {
        /*
        $this->locales = mdDynamicContentHandler::retrieveAllMdDynamicContentOfType("locales", true);
        
        $this->puntosVenta = mdDynamicContentHandler::retrieveAllMdDynamicContentOfType("puntoVenta", true);
        */
        $params = array();
        
        mdMetaTagsHandler::addMetas($this,'locacion', array('params'=>$params));
    }
    
    public function executeGaleria(sfWebRequest $request)
    {
        $this->images = mdImageFileGallery::getImagesByDate(array('path'=>"inicio", 'order'=>'desc', 'absolute'=>false));
        
        $params = array();
        mdMetaTagsHandler::addMetas($this,'galeria', array('params'=>$params));
    }
    
    public function executeQuienesSomos(sfWebRequest $request)
    {
        
        $params = array();
        //mdMetaTagsHandler::addMetas($this,'quienesSomos', array('params'=>$params, 'debug'=>true));
        mdMetaTagsHandler::addMetas($this,'quienesSomos', array('params'=>$params));
    }
    
    public function executeError404(sfWebRequest $request)
    {
        
    }
    
	public function executeError500(sfWebRequest $request)
    {
        
    }
    
}
