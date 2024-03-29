<?php

class productosComponents extends sfComponents {

    public function executeCategoriasMenu(sfWebRequest $request)
    {
      $this->categorias = mdCategoryHandler::retrieveAllParentCategoriesOfClass("mdProduct");
    }
	
	public function executeBuscador(sfWebRequest $request)
	{
	  $this->form = new searchForm(array(), array(), false);
	}
  
  public function executeProductoBusqueda(sfWebRequest $request)
  {
    $this->producto = MdProductHandler::retrieveMdProductById($this->id);
    
    $categories = $this->producto->getmdCategories();
    $this->show = false;
    if(count($categories) > 0)
    {
      $this->show = true;
      $this->slug = $categories->end()->getSlug();
    }
    
  }

}
