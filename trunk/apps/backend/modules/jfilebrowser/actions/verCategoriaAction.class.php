<?php

class verCategoriaAction extends sfAction {

    public function execute($request)
    {
      $name = $request->getParameter('id');
      $view = $request->getParameter('view', 'thumbnails');

      $archivos = jfilebrowser::getFiles($name);
      
      $this->pager = new mdArrayPager(null, sfConfig::get('app_mdImageFileGallery_list_pagerSize',30));
      $this->pager->setResultArray($archivos);
      $this->pager->setPage($this->getRequestParameter('page',1));
      $this->pager->init();
      return $this->renderText($this->getPartial('verCategoria', array('id' => $name, 'view' => $view, 'archivos' => $archivos)));
    }
    
}
