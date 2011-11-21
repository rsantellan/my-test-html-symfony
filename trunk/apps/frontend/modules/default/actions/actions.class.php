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
    
    public function executeIndex(sfWebRequest $request)
    {
        
    }
    
    public function executeLocation(sfWebRequest $request)
    {
        $this->locales = mdDynamicContentHandler::retrieveAllMdDynamicContentOfType("locales", true);
        
        $this->puntosVenta = mdDynamicContentHandler::retrieveAllMdDynamicContentOfType("puntoVenta", true);
    }
    
    public function executeError404(sfWebRequest $request)
    {
        
    }
    
    
}
