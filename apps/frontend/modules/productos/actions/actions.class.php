<?php

/**
 * productos actions.
 *
 * @package    naturalia
 * @subpackage productos
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class productosActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      
  }
  
  public function executeCategoria(sfWebRequest $request)
  {
      $slug = $request->getParameter("slug");
      $this->category = mdCategoryHandler::retrieveBySlug($slug, $this->getUser()->getCulture());
      
      $this->mySlots = array();
      $this->mySlots[] = $slug;
      $this->parent = $this->category->getMdParentCategory();
      while(!is_null($this->parent))
      {
          $this->mySlots[] = $this->parent->getSlug();
          
          $this->parent = $this->parent->getMdParentCategory();
      }
      
      $this->listadoProductos = MdProductHandler::retrieveProductsByCategory($this->category->getId());
  }
  
}
