<?php

class productosComponents extends sfComponents {

    public function executeCategoriasMenu(sfWebRequest $request)
    {
      $this->categorias = mdCategoryHandler::retrieveAllParentCategoriesOfClass("mdProduct");
    }

}