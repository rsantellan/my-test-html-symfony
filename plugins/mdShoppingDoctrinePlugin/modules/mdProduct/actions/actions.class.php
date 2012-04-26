<?php

/**
 * mdProduct actions.
 *
 * @package    demo
 * @subpackage mdProduct
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdProductActions extends sfActions
{
    public function preExecute(){
        if(!$this->getUser()->hasPermission('Admin')  && $this->getUser()->isAuthenticated()){
            $this->redirect ( '@homepage' );
        }
    }

    public function executeIndex(sfWebRequest $request)
    {
        $this->typeName = $request->getParameter('typeName', NULL);
        
        $this->md_units = Doctrine::getTable('mdUnit')
          ->createQuery('a')
          ->execute();

        $this->pager = new sfDoctrinePager ( 'mdProducts', sfConfig::get ( 'app_max__shown_products', 10 ) );

        $query = Doctrine::getTable ( 'mdProduct' )->createQueryForAdmin();

        if($this->typeName)
        {
            $query = MdProductHandler::retrieveAllMdProductsOfAProfile($this->typeName, true);
            $query = Doctrine::getTable ( 'mdProduct' )->addPriorityToQuery($query);
        }
        else
        {
            //$query = Doctrine::getTable ( 'mdProduct' )->createQuery('a');
        }
        $this->pager->setQuery ( $query );

        $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );

        $this->pager->init ();

        $this->formFilter = new mdProductFormFilter();
        

    /*	$mdProduct = Doctrine::getTable ( 'mdProduct' )->find (2 );
        $mdProduct->getOrderedCategories();
        die;*/
    }

    public function executeFilter(sfWebRequest $request){
        $this->md_units = Doctrine::getTable('mdUnit')
          ->createQuery('a')
          ->execute();
        
        $this->formFilter = new mdProductFormFilter();
        $this->formFilter->bind($request->getParameter('md_product_filters'));

        if ($this->formFilter->isValid()){
            $this->search = $this->formFilter->buildQuery($this->formFilter->getValues());
        } else {
            echo 'no valido ' . $this->formFilter->getErrorSchema() ;
        }
        $this->search = Doctrine::getTable("mdProduct")->addPriorityToQuery($this->search);
        $this->pager = new sfDoctrinePager ( 'mdProduct', sfConfig::get ( 'app_max__shown_products' ) );
        $this->pager->setQuery ( $this->search );
        $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
        $this->pager->init();

        //print_r(count($this->pager->getResults())); die();
    
        $this->setTemplate('index');
    }

    private function addAttributesAndProfile($mdProduct, $postParameters){
        if( sfConfig::get( 'sf_plugins_shopping_attribute', false ) )
        {
            $hasProfile = false;
            $mdAttributeParameters = array();

            foreach($postParameters as $param)
            {
              if(is_array($param))
              {
                  foreach($param as $secondParam)
                  {
                      if(is_array($secondParam))
                      {
                          if(isset($secondParam['mdProfileId']))
                          {
                              $hasProfile = true;
                              $mdProduct->addTmpArrayMdProfileId($secondParam['mdProfileId']);
                              $mdAttributeParameters[$secondParam['mdProfileId']] = $secondParam;
                              //array_push($mdAttributeParameters, $secondParam);
                          }
                      }
                  }
              }
            }

            if ($hasProfile)
            {
              $mdProduct->setEmbedProfile(true);
              $mdProduct->setTmpMdAttributesValues($mdAttributeParameters);
            }
            else
            {
              $mdProduct->setEmbedProfile(false);
            }
        }

        return $mdProduct;
    }

    /**
     * Formulario para Alta de Productos
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeAddBox(sfWebRequest $request){
        $salida = "";
        
        
        $mdProduct = new mdProduct();
        $type_name = $request->getParameter('typeName', NULL);
        if($type_name)
        {
            $mdProfile = mdProfileHandler::retrieveMdProfileByName($type_name);
            $mdProduct->addTmpArrayMdProfileId($mdProfile->getId());
            $mdProduct->setEmbedProfile(true);
        }
        else
        {
            $mdProfiles = MdProductHandler::retrieveAllUsableMdProfile();
            if(count($mdProfiles) == 1){
                $mdProduct->addTmpArrayMdProfileId($mdProfiles[0]->getId());
                $mdProduct->setEmbedProfile(true);
            }
        }
        
        $mdProduct->setMdCurrencyId(sfConfig::get('sf_plugins_products_default_currency', 1));
        
        $form = new mdProductForm($mdProduct);

        $salida = $this->getPartial('add_box', array('form' => $form));

        return $this->renderText(json_encode( array('content' => $salida)));
    }

    /**
     * Formulario expandido para Editar Productos
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeOpenBox(sfWebRequest $request){
        $mdProduct = Doctrine::getTable('mdProduct')->find(array($request->getParameter('id')));
        $this->md_units = Doctrine::getTable('mdUnit')->createQuery('a')->execute();

        //$mdProduct->saveTmpMdProfileId( $request->getParameter ( 'mdProfileId', sfConfig::get('app_md_profile_md_product_default', 1)) );

        $salida = array();
        $salida['content'] = $this->getPartial ( 'open_box', array ('form'=> new mdProductForm($mdProduct), 'md_units'=> $this->md_units ) );
        $salida['id'] = $mdProduct->getId();
        $salida['className'] = $mdProduct->getObjectClass();

        return $this->renderText(json_encode($salida));
    }

    /**
     * Accordion Cerrado con algunos datos del Producto
     *
     * @param sfWebRequest $request
     * @return <type>
     */
    public function executeClosedBox(sfWebRequest $request){
        $mdProduct = Doctrine::getTable ( 'mdProduct' )->find ( array ($request->getParameter ( 'id' ) ) );

        return $this->renderText(json_encode(array('content' => $this->getPartial('closed_box', array ('object' => $mdProduct )))));
    }

    /**
     * Metodo que guarda un producto y sus attributos, ya sea un producto nuevo
     * o un producto existente
     *
     * @param sfWebRequest $request
     * @return json_encode
     */
    public function executeSaveProduct(sfWebRequest $request){

        $postParameters = $request->getParameter('md_product');
        $hasId = NULL;
        if(is_numeric($postParameters['id'])){
            $this->forward404Unless($mdProduct = Doctrine::getTable('mdProduct')->find(array($postParameters['id'])), sprintf('Object md_product does not exist (%s).', $request->getParameter('id')));
            $hasId = $postParameters['id'];
        } else {
            $mdProduct = new mdProduct();
        }

        $mdProduct = $this->addAttributesAndProfile($mdProduct, $postParameters);

        if(is_null($hasId))
        {
            $mdProduct->setMdUserIdTmp($this->getUser()->getMdUserId());
        }
        

        $formAux = new mdProductForm();

        $params = $request->getParameter($formAux->getName());

        $form = new mdProductForm($mdProduct);
        
        if(!is_null($hasId))
        {
			//TODO Esto fue comentado en el merge
            /*if(!isset($params[$this->getUser()->getCulture()]))
            {
                $params[$this->getUser()->getCulture] = $this->getUser()->getCulture();
            }
            if(!isset($params[$this->getUser()->getCulture()]['id']))
            {
                $params[$this->getUser()->getCulture()]['id'] = $hasId;
            }
            if(!isset($params[$this->getUser()->getCulture()]['lang']))
            {
                $params[$this->getUser()->getCulture()]['lang'] = $this->getUser()->getCulture();
            }*/
        }
        $form->bind($params);

        $salida = array();

        if($form->isNew()){
            if($form->isValid()){
                sfContext::getInstance()->getLogger()->info('<! ACEPTA LOS CHEQUEOS !>');
                $product = $form->save();
                $md_units = Doctrine::getTable('mdUnit')->createQuery('a')->execute();
                $form = new mdProductForm($product);

                $salida['result'] = 1;
                $salida['content'] = $this->getPartial ( 'open_box', array ('form'=> $form, 'md_units'=> $md_units ) );
                $salida['id'] = $mdProduct->getId();
                $salida['className'] = $mdProduct->getObjectClass();
            }else{
                //print_r($params);
                sfContext::getInstance()->getLogger()->info('<! No acepto los chequeos !>');
                $errors = $form->getFormattedErrors();
                foreach($errors as $err)
                {
                    sfContext::getInstance()->getLogger()->err('<!!! ERR: '.$err );
                }
                $body = $this->getPartial ( 'add_box', array ('form'=> $form) );
                $salida['result'] = 0;
                $salida['body'] = $body;
            }
        } else {
            if($form->isValid()){
                sfContext::getInstance()->getLogger()->info('<! ACEPTA LOS CHEQUEOS !>');
                //print_r($paramList);die;
                $product = $form->save();
                $salida['result'] = 1;
                $salida['content'] = $this->getPartial ( 'closed_box', array ('object' => $product ) );
                $salida['id'] = $product->getId();
                $salida['className'] = $product->getObjectClass();
            } else {
                sfContext::getInstance()->getLogger()->info('<! No acepto los chequeos !>');
                $errors = $form->getFormattedErrors();
                foreach($errors as $err)
                {
                    sfContext::getInstance()->getLogger()->err('<!!! ERR: '.$err );
                }
                $this->md_units = Doctrine::getTable('mdUnit')
                                    ->createQuery('a')
                                    ->execute();
                $openProduct = $this->getPartial ( 'open_box', array ('form'=> $form, 'md_units'=> $this->md_units ) );
                $salida['result'] = 0;
                $salida['body'] = $openProduct;

            }
        }
        if($salida['result'] == 1)
        {
          $this->clearCache($salida['id']);
        }
        return $this->renderText(json_encode($salida));
    }




    //VER DONDE SE USAN ESTASACCIONES

    public function executeGetAddCategoryToProductsAjax(sfWebRequest $request) {
        $mdProduct = Doctrine::getTable ( 'mdProduct' )->find ( array ($request->getParameter ( 'mdProductId' ) ) );
        $mdCategory = Doctrine::getTable('mdCategory')->find( array ($request->getParameter ( 'mdCategoryId' ) ) );
        $mdProductCategory = new mdProductCategory();
        $mdProductCategory->setMdCategory($mdCategory);
        $mdProductCategory->setMdProduct($mdProduct);
        $mdProductCategory->save();
        $parentCategories = Doctrine::getTable('mdCategory')->getOnlyParents('mdProduct');
        return $this->renderPartial('showMdCategoryTreeNode', array('tree' => $mdProduct->getOrderedCategories()));

    }

    public function executeGetRemoveCategoryToProductsAjax(sfWebRequest $request) {
        $mdProduct = Doctrine::getTable ( 'mdProduct' )->find ( array ($request->getParameter ( 'mdProductId' ) ) );
        $ProducCategory = Doctrine::getTable('mdProductCategory')->getProductCategory($mdProduct->getId(), $request->getParameter ( 'mdCategoryId' ));
        $ProducCategory->delete();
        return $this->renderText('ok');
    }

    public function executeGetUpdateCategoriesOfProductsAjax(sfWebRequest $request) {
        $mdProduct = Doctrine::getTable ( 'mdProduct' )->find ( array ($request->getParameter ( 'mdProductId' ) ) );
        return $this->renderPartial('showMdCategoryTreeNode', array('tree' => $mdProduct->getOrderedCategories()));
    }

    public function executeAddTagsForProductsAjax(sfWebRequest $request){
        $tags = $request->getParameter('tags');
        $salida['tags'] = $tags;
        //agregar logica que guarda los tags
        return $this->renderText(json_encode($salida));
    }

    public function executeGetAddCategoryForProductsAjax(sfWebRequest $request) {
        $mdProduct = Doctrine::getTable ( 'mdProduct' )->find ( array ($request->getParameter ( 'mdProductId' ) ) );
        $parentCategories = Doctrine::getTable('mdCategory')->getOnlyParents('mdProduct');
        return $this->renderPartial ('addCategory',array('parentCategories'=>$parentCategories,'mdProduct'=> $mdProduct));
    }

    public function executeDeleteProduct(sfWebRequest $request)
    {
        $salida = array();
        try{

            $mdProduct = Doctrine::getTable('mdProduct')->find(array($request->getParameter('id')));
            $mdProduct->delete();

            $salida['response'] = 'OK';
            return $this->renderText(json_encode($salida));

        }catch(Exception $e){

            $salida['response'] = 'ERROR';
            $salida['message'] = $e->getMessage();
            return $this->renderText(json_encode($salida));

        }
    }

    public function executeListProfiles(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Create Product')) {
            return $this->renderText( array('result' => 0, 'body' => '') );
        }
        $mdProfiles = Doctrine::getTable('mdProfile')->getMdProfilesOfApplication($request->getPostParameter('mdAppId'), 'mdProduct');
        $salida = array('result' => 1, 'body' => $this->getPartial('listProfiles', array('mdProfiles' => $mdProfiles)));
        return $this->renderText ( json_encode ( $salida ) );
    }

    public function executeShowProfileAjax(sfWebRequest $request) {
        $salida = '';
        $mdProfileId = $request->getPostParameter('mdProfileId');
        $mdApplicationId = $request->getPostParameter('mdAppId');
        $mdPassportId = $request->getPostParameter('mdPassportId');

        if (!$this->getUser()->hasPermission('Backend Create Product') && !mdApplication::hasPermission($mdPassport,'Create Product', $mdApplicationId)) {
            return $this->renderText( array('result' => 0, 'body' => '') );
        }

        $mdProduct = new mdProduct();
        if($mdProfileId){
            $mdProduct->setTmpMdProfileId($mdProfileId);
        }
        $mdProduct->setMdApplicationIdTmp($mdApplicationId);
        $form = new mdProductForm($mdProduct);

        $salida = $this->getPartial('newProduct', array('form'=> $form, 'mdApplicationId' => $mdApplicationId));

        return $this->renderText ( json_encode ( array('result' => 1, 'body' => $salida) ) );
    }

    public function executeChangeProductVisibilityAjax(sfWebRequest $request) {
        if (!$this->getUser()->hasPermission('Backend Create Product')) {
            return $this->renderText( json_encode(array('result' => 0, 'body' => '')) );
        }

        $md_product = Doctrine::getTable('mdProduct')->find($request->getParameter('mdProductId'));
        $md_product->setIsPublic(!$md_product->getIsPublic());
        $md_product->save();

        if($md_product->getIsPublic() == true){
            $is_public = "Desactivar";
        } else {
            $is_public = "Activar";
        }

        return $this->renderText( json_encode(array('response' => 'OK', 'result' => $is_public, 'body' => '')) );
    }

    public function executeAddRelatedProducAjax(sfWebRequest $request)
    {
    	$mdProduct = Doctrine::getTable('mdProduct')->find($request->getParameter('mdProductId'));
    	$mdProductRelated = Doctrine::getTable('mdProduct')->find($request->getParameter('mdProductRelatedId'));
    	try{
    		$mdProduct->addContent($mdProductRelated);
    		$salida ['result'] = 1;
        	$salida ['body'] = $mdProduct->getPriceWithRelated() ;
    	}catch(Exception $e){
    		$salida ['result'] = 0;
        	$salida ['body'] = 0 ;
    	}


    	return $this->renderText ( json_encode ( $salida ) );
    }


    public function executeSaveProfileAjax(sfWebRequest $request)
    {
        $parameters = $request->getPostParameters();
        $md_object = Doctrine::getTable('mdProduct')->find($parameters['mdObjectId']);
        $values;
        foreach($parameters as $param)
        {
            if(is_array($param))
            {
            $values = $param;
            }
        }
        $form = $md_object->getAttributesFormOfMdProfileById($values['mdProfileId']);

        $form->bind($values);
        if($form->isValid()){
            $md_object->saveAllAttributes($form);
            $this->clearCache($parameters['mdObjectId']);
            return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
        }
        else
        {
            $profile = Doctrine::getTable("mdProfile")->find($values['mdProfileId']);
            $body = $this->getPartial('mdProduct/profile_form', array('form'=>$form,'name'=> $profile->getName(), 'mdProfileId' => $profile->getId(), 'mdObjectId' => $parameters['mdObjectId'] ));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array('profileId'=>$profile->getId(), 'body'=>$body)));
            //include_partial('profile_form', array('form'=>$profForm,'name'=> $prof->getMdProfile()->getName(), 'mdProfileId' => $prof->getMdProfile()->getId(), 'mdObjectId' => $form->getObject()->getId() ))
        }
        $salida = array();
        $salida ['result'] = 0;
        return $this->renderText(json_encode($salida));
    }
    
    private function clearCache($id)
    {
      $cacheManager = $this->getContext()->getViewCacheManager();
      if($cacheManager)
      {
        $cacheManager->remove('@sf_cache_partial?module=mdProduct&action=__closed_box&sf_cache_key=mdProduct_'.$id);
      }
    }
}
