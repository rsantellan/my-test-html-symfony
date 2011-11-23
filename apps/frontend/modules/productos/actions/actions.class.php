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
  
  
  public function postExecute()
  {
      mdMetaTagsHandler::addGenericMetas($this, null, array());
  }  
  
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
      $this->getUser()->setFlash("categoryCacheKey", "-");
	  $params = array();
	  mdMetaTagsHandler::addMetas($this,'productos', array('params'=>$params));
  }
  
  public function executeCategoria(sfWebRequest $request)
  {
      $slug = $request->getParameter("slug");
      $this->category = mdCategoryHandler::retrieveBySlug($slug, $this->getUser()->getCulture());
      
      $this->mySlots = array();
      $this->mySlots[] = $slug;
      $categoryCacheKey = $slug;
      $this->parent = $this->category->getMdParentCategory();
      while(!is_null($this->parent))
      {
          $this->mySlots[] = $this->parent->getSlug();
          $categoryCacheKey .= "_".$this->parent->getSlug();
          $this->parent = $this->parent->getMdParentCategory();
      }
      //$categoryCacheKey = $comma_separated = implode("_", $this->mySlots);
      $this->getUser()->setFlash("categoryCacheKey", $categoryCacheKey);
      //$this->listadoProductos = MdProductHandler::retrieveProductsByCategory($this->category->getId());
      $options = array();
      $options["return_query"] = true;
      $query = MdProductHandler::retrieveProductsByCategory($this->category->getId(), $options);
      $this->quantity = 6;
      $this->pager = new sfDoctrinePager ( 'mdProduct', $this->quantity );
      $this->pager->setQuery ( $query );
      $this->pager->setPage($this->getRequestParameter('page',1));
      $this->pager->init();
	  
	  $params = array();
	  $params['[Categoria]'] = $this->category->getName();
	  mdMetaTagsHandler::addMetas($this,'categoria', array('params'=>$params, 'debug'=>true));
  }
  
  public function executeDetalleProducto(sfWebRequest $request)
  {
      $id = $request->getParameter("id");
      $categorySlug = $request->getParameter("categoria");
      $this->page = $request->getParameter("page", 1);
      $this->category = mdCategoryHandler::retrieveBySlug($categorySlug, $this->getUser()->getCulture());
      $this->mySlots = array();
      $this->mySlots[] = $categorySlug;
      $categoryCacheKey = $categorySlug;
      $this->parent = $this->category->getMdParentCategory();
      while(!is_null($this->parent))
      {
          $this->mySlots[] = $this->parent->getSlug();
          $categoryCacheKey .= "_".$this->parent->getSlug();
          $this->parent = $this->parent->getMdParentCategory();
      }
      //$categoryCacheKey = $comma_separated = implode("_", $this->mySlots);
      $this->getUser()->setFlash("categoryCacheKey", $categoryCacheKey);
      $this->producto = MdProductHandler::retrieveMdProductById($id);
  }
  
}
