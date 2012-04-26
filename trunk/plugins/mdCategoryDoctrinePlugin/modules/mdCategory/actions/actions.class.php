<?php
class mdCategoryActions extends sfActions
{
    
    public function preExecute() {
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
            if (!$this->getUser()->hasPermission('Backend Category Show List')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
        }
    }

    public function executeIndex(sfWebRequest $request)
    {
        //Obtener todas las categorias root
        $this->mdCategories = Doctrine::getTable('mdCategory')->getRoots();
        if(count($this->mdCategories) == 0)
        {
            throw new Exception($this->getContext()->getI18N()->__('mdCategoryDoctrine_text_noCategoryException'), 100);
        }
        //Obtener todas las subcategorias recursivamente hijas del primer root
        $first = $this->mdCategories->getFirst();
        
        $childs = array();
        if($first){
            $childs = Doctrine::getTable('mdCategory')->getAllChilds($first->getId());
        }

        if(sfConfig::get('sf_plugins_category_show_root', true)){
            array_unshift($childs, $first);
        }

        $this->childs = $childs;
    }

    public function executeShowCategoryForm(sfWebRequest $request)
    {
        $salida = "";
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) )
        {
            if (!$this->getUser()->hasPermission('Backend Create Category'))
            {
                return $this->renderText ( $salida );
            }
        }

        $categoryRootId = $request->getParameter('categoryId');

        $mdCategory = Doctrine::getTable('mdCategory')->find($categoryRootId);
        $newMdCategory = new mdCategory();
        $newMdCategory->setObjectClassName($mdCategory->getObjectClassName());

        $categoryProfileDisplay = sfConfig::get( 'app_plugins_category_display', null );
        $hasProfile = false;

        if(!is_null($categoryProfileDisplay))
        {
          foreach($categoryProfileDisplay as $categoryProfile)
          {
            if($categoryProfile['category_parent_id'] == $categoryRootId)
            {
                $hasProfile = true;
                $newMdCategory->addTmpArrayMdProfileId($categoryProfile['profile_id']);      
            }
          }
          if ($hasProfile) 
          {
            $newMdCategory->setEmbedProfile(true);
          } 
          else 
          {
            $newMdCategory->setEmbedProfile(false);
          }
        }

				$newMdCategory->setMdCategoryParentId($categoryRootId);

        $form = new mdCategoryForm($newMdCategory);

        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('category_form', array('form' => $form))
        )));
        
    }

    public function executeCreateCategory(sfWebRequest $request)
    {

        $postParamenters = $request->getPostParameter('md_category');
        
        $mdCategory = new mdCategory();
        
        if( sfConfig::get( 'sf_plugins_category_attributes', false ) )
        {
          $hasProfile = false;
          $mdAttributeParameters = array();
          foreach($postParamenters as $param)
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
                              $mdCategory->addTmpArrayMdProfileId($secondParam['mdProfileId']);
                              $mdAttributeParameters[$secondParam['mdProfileId']] = $secondParam;
                              //array_push($mdAttributeParameters, $secondParam);
                          }
                      }
                  }
              }
          }
          if ($hasProfile)
          {
              $mdCategory->setEmbedProfile(true);
              $mdCategory->setTmpMdAttributesValues($mdAttributeParameters);
          }
          else
          {
              $mdCategory->setEmbedProfile(false);
          }
        }
        
        $formAux = new mdCategoryForm();
        
        $params = $request->getParameter($formAux->getName());

        $objectClassName = $params['object_class_name'];
        $mdCategory->setObjectClassName($objectClassName); 

        $form = new mdCategoryForm($mdCategory);
        $form->bind($params);

        $salida = array();
        if($form->isValid())
        {
            $category = $form->save();

            $parentId = 0;
            if($category->getMdCategoryParentId()) $parentId = $category->obtainRoot()->getId();

            $childs = array();
            if($category){
                $categoryId = $category->getId();
                if($parentId != 0){
                    $categoryId = $category->obtainRoot()->getId();
                }
                $childs = Doctrine::getTable('mdCategory')->getAllChilds($categoryId);
            }
            array_push($childs, $category);

            //PREPARO LA SALIDA
            $form = new mdCategoryForm($category, array(), array('object_class_name' => $category->getObjectClassName()));
            $salida['response'] = 'OK';
            $salida['tab_li'] = "";//$this->getPartial('tabs_li', array('mdCategory' => $category));
            //$salida['tab_a'] = $this->getPartial('tabs_a',array('mdRule'=>$rule));
            $salida['object_id'] = $category->getId();
            $salida['className'] = $category->getObjectClassName();
            $salida['name'] = $category->getName();
            $salida['content'] = '';
            $auxCategory = $category;
            if($parentId != 0)
            {
                $auxCategory = $category->obtainRoot();
            }
            $salida['response'] = 'OK';
            if($parentId == 0)
            {
                $salida['body'] = $this->getPartial('mdCategory/tabs_container', array('mdCategory'=>$auxCategory, 'childs'=>$childs, 'i'=> 1));
            }
            else
            {
                $salida['body'] = $this->getPartial('closedCategory',array('category'=> $category));
            }
            $salida['product_id'] = $category->getId();
            $salida['className'] = $category->getObjectClassName();

            $salida['parent_id'] = $parentId;
            $salida['content'] = '';
        }
        else
        {
            //print_r($form->getFormattedErrors());
            //die;
            $salida['response'] = 'ERROR';
            $salida['body'] = $this->getPartial ( 'category_form', array ('form'=> $form) );
            $salida['product_id'] = '';
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeShowOpenCategory(sfWebRequest $request)
    {
        $mdCategory = Doctrine::getTable( 'mdCategory' )->find($request->getParameter( 'mdCategoryId' ));
        //$form = new mdCategoryForm($mdCategory);
        $form = new mdCategoryForm($mdCategory, array(), array('object_class_name' => $mdCategory->getObjectClassName()), false);

        //PREPARO LA SALIDA

        return $this->renderText(json_encode(array(
            'content' => $this->getPartial('openCategory', array('form' => $form)),
            'id' => $mdCategory->getId(),
            'className' => $mdCategory->getObjectClass()
        )));
    }

    public function executeSaveProfileAjax(sfWebRequest $request)
    {
        $parameters = $request->getPostParameters();
        $md_object = Doctrine::getTable('mdCategory')->find($parameters['mdObjectId']);
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
        $salida = array();
        
        if($form->isValid())
        {
            $md_object->saveAllAttributes($form);
            
            return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
        }
        else
        {
            $profile = Doctrine::getTable("mdProfile")->find($values['mdProfileId']);
            $body = $this->getPartial('md_category_profile_form', array('form'=>$form,'name'=> $profile->getName(), 'mdProfileId' => $profile->getId(), 'mdObjectId' => $parameters['mdObjectId'] ));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array('profileId'=>$profile->getId(), 'body'=>$body)));
        }

    }

    public function executeDeleteCategory(sfWebRequest $request)
    {
        $salida = array();
        try{

            $mdCategory = Doctrine::getTable('mdCategory')->find(array($request->getParameter('id')));
            $mdCategoryParentId = 0;
            if($mdCategory->getMdCategoryParentId())
            {
              $mdCategoryParentId = $mdCategory->getMdCategoryParentId();
            }
            $mdCategory->delete();
            $salida['response'] = 'OK';
            $salida['parentId'] = $mdCategoryParentId;
            $salida['id'] = $request->getParameter('id');
            return $this->renderText(json_encode($salida));

        }catch(Exception $e){

            $salida['response'] = 'ERROR';
            $salida['message'] = $e->getMessage();
            return $this->renderText(json_encode($salida));

        }
    }    

    public function executeLoadTabContent(sfWebRequest $request)
    {
        $mdCategoryId = $request->getParameter('mdCategoryId');

        $mdCategory = mdCategoryHandler::retrieveCategory($mdCategoryId);

        $childs = Doctrine::getTable('mdCategory')->getAllChilds($mdCategory->getId());
        
        if(sfConfig::get('sf_plugins_category_show_root', true)){
            array_unshift($childs, $mdCategory);
        }

        $content = $this->getPartial('mdCategory/closedCategoriesList', array('mdParentCategory' =>  $mdCategory, 'mdCategories' => $childs));

        $result = array('response' => 'OK', 'content' => $content, 'tabId'=>$mdCategoryId);

        return $this->renderText(json_encode($result));
    }
    
    public function executeEditCategory(sfWebRequest $request)
    {
        $params = $request->getPostParameters();

        $mdCategoryId = $params['md_category']['id'];
        $mdCategory = Doctrine::getTable('mdCategory')->find($mdCategoryId);

        if( sfConfig::get( 'sf_plugins_category_attributes', false ) )
        {
          $hasProfile = false;
          $mdAttributeParameters = array();
          if(isset($params['md_category']['mdAttributes']))
          {
            foreach($params['md_category']['mdAttributes'] as $param)
            {
                if(isset($param['mdProfileId']))
                {
                  $hasProfile = true;
                  $mdCategory->addTmpArrayMdProfileId($param['mdProfileId']);
                  $mdAttributeParameters[$param['mdProfileId']] = $param;
                }
            }            
          }

          if ($hasProfile)
          {
              $mdCategory->setEmbedProfile(true);
              $mdCategory->setTmpMdAttributesValues($mdAttributeParameters);
          }
          else
          {
              $mdCategory->setEmbedProfile(false);
          }
        }

        $form = new mdCategoryForm($mdCategory, array(), array(), false);
        $params = $this->request->getParameter($form->getName());
        if($params[$form->getName() . '_parent_id'] == '0')
        {
            unset($params[$form->getName() . '_parent_id']);
        }

        $form->bind($params);

        $salida = array();
        if($form->isValid())
        {
            $mdCategoryAux = $form->save();

            //PREPARO LA SALIDA
            $salida['response'] = 'OK';
            $salida['product_id'] = $mdCategoryAux->getId();
        }
        else
        {

            $salida['response'] = 'ERROR';
            $salida['body'] = $this->getPartial ( 'category_info', array ('form'=> $form) );
            $salida['product_id'] = '';
        }
        return $this->renderText(json_encode($salida));
    }    
    
    public function executeChangePriority(sfWebRequest $request)
    {
      $mdCategoryId = $request->getParameter('mdCategoryId');

      $value = $request->getParameter('value');
      
      $priority = mdCategoryHandler::changePriority($mdCategoryId, $value);
      $salida = array();
      $salida['priority'] = $priority;
      return $this->renderText(json_encode($salida));
    }
        
    /********************
     *
     * Revisado hasta aca
     *
     ********************/

    public function executeShowClosedCategory(sfWebRequest $request)
    {
        $mdProduct = Doctrine::getTable( 'mdCategory' )->find ($request->getParameter( 'mdCategoryId' ));
        $salida = array();
        $salida['response'] = 'OK';
        $salida['product'] = $this->getPartial( 'closedCategory', array ('category' => $mdProduct ) );
        return $this->renderText($salida['product']);
    }

}
