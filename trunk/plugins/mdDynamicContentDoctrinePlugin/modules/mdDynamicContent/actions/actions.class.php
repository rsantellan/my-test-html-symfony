<?php

/**
 * default actions.
 *
 * @package    aeromarket
 * @subpackage default
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdDynamicContentActions extends sfActions
{

    public function preExecute() {
        if( sfConfig::get( 'sf_plugins_user_groups_permissions', false ) ){
            if (!$this->getUser()->hasPermission('Admin')) {
                $this->getUser()->setFlash('noPermission', 'noPermission');
                $this->redirect($this->getRequest()->getReferer());
            }
        }
    }
    
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    try
    {

        $this->typeName = $request->getParameter('typeName', NULL);

        $this->pager = new sfDoctrinePager ( 'mdDynamicContent', sfConfig::get ( 'app_max_shown_dynamic',10 ) );

        $this->pager->setQuery ( mdDynamicContent::retrieveCollection($this->typeName, true) );

        $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );

        $this->pager->init ();

        $this->formFilter = new mdDynamicContentFormFilter(array($this->typeName));
        $this->isFiltered = false;
    }
    catch(Exception $e)
    {
        echo 'ERROR ' . $e->getMessage();
    }


  }
  
  public function executeAddMdDynamicContent(sfWebRequest $request)
  {
    $this->typeName = $request->getParameter('typeName', NULL);
    
    $result = array();
    
    if(!($this->typeName))
    {
      $result = $this->retrieveNonTypeNameAddMdDynamicContent();
    }
    else
    {
      $result = $this->retrieveTypeNameAddMdDynamicContent($this->typeName);
    }
    return $this->renderText(json_encode($result));
  }

  /**
   * @author Rodrigo Santellan
   * return Array {'response', 'newForm'}
   */   
  private function retrieveTypeNameAddMdDynamicContent($typeName)
  {
    $configuration = contentHandler::getInstance()->retrieveConfiguration(contentHandler::DYNAMIC_CONTENT, $typeName);
    
    $mdDynamicContent = new mdDynamicContent();
    
    $hasProfile = true;
    $mdDynamicContent->addTmpArrayMdProfileId($configuration['profileId']);      
    return $this->retrieveMdDynamicContentForm($mdDynamicContent, $hasProfile);
  }
  
  /**
   * @author Rodrigo Santellan
   * return Array {'response', 'newForm'}
   */   
  private function retrieveMdDynamicContentForm($mdDynamicContent, $hasProfile)
  {
    if ($hasProfile) 
      {
        $mdDynamicContent->setEmbedProfile(true);
      } 
      else 
      {
        $mdDynamicContent->setEmbedProfile(false);
      }
      
      $form = new mdDynamicContentForm($mdDynamicContent);
      
      return $this->getPartial('addMdDynamic', array('form' => $form));

  }
  
  /**
   * @author Rodrigo Santellan
   * return Array {'response', 'newForm'}
   */ 
  private function retrieveNonTypeNameAddMdDynamicContent()
  {
    $mdProfiles = Doctrine::getTable('mdProfile')->getMdProfilesByObjectClassName('mdDynamicContent');

    $defaultProfiles = sfConfig::get( 'app_plugins_dynamic_show_default_profiles', null );
    
    if(!is_null($defaultProfiles))
    {
      
      $hasProfile = false;
      
      $mdDynamicContent = new mdDynamicContent();
      if(!is_array($defaultProfiles))
      {
          $defaultProfiles = array($defaultProfiles);

      }
      foreach($defaultProfiles as $mdProfileId)
      {
        $hasProfile = true;
        $mdDynamicContent->addTmpArrayMdProfileId($mdProfileId);      
      }
      
      return $this->retrieveMdDynamicContentForm($mdDynamicContent, $hasProfile);
    }
    else
    {
      return $this->getPartial('newMdDynamicProfiles', array('mdProfiles' => $mdProfiles, 'mdUserId' => $this->getUser()->getMdUserId()));
    }

  }
  
    public function executeShowProfileAjax(sfWebRequest $request) {
        //if (!$this->getUser()->hasPermission('Backend Create User')) {
        //  return $this->renderText(array('result' => 1, 'body' => ''));
        //}
        $salida = '';
        $mdDynamicContentId = $request->getPostParameter('mdDynamicContentId', '');
        $mdProfileId = $request->getPostParameter('mdProfileId');
        $mdDynamicContent = new mdDynamicContent();

        // Decido si le embebo el perfil
        $mdUserProfile = new mdUserProfile();
        if ($mdProfileId) {
            if ($mdProfileId == 0) {
                $mdDynamicContent->setEmbedProfile(false);
            } else {
                $mdDynamicContent->addTmpArrayMdProfileId($mdProfileId);
                $mdDynamicContent->setEmbedProfile(true);
            }
        }
        
        // Creo el formulario dynamicContentForm
        $form = new mdDynamicContentForm($mdDynamicContent);
        if ($mdDynamicContentId == '') {
            $salida = $this->getPartial('addMdDynamic', array('form' => $form));
        } else {
            if ($mdProfileId) {
                $form = $mdUserProfile->getAttributesFormOfMdProfileById($mdProfileId);
                $salida = $this->getPartial('newProfileUserForm', array('form' => $form, 'mdUserId' => $mdUserId, 'mdApplicationId' => $mdApplicationId, 'mdPassportId' => $mdPassportId));
            }
        }
        //print_r($salida);
        return $this->renderText(json_encode(array('result' => 0, 'body' => $salida)));
    }

    public function executeCreateDynamicContent(sfWebRequest $request)
    {
        $form = $this->saveContent($request);
        if($form->isValid())
        {
          $mdDynamicContent = $form->getObject();
          $mdDynamicContent->setEmbedProfile(false);
          $body = $this->getPartial('openMdObject', array('form'=> new mdDynamicContentForm($mdDynamicContent)));
          $salida ['result'] = 1;
          $salida ['body'] = $body;
          $salida['object_id'] = $mdDynamicContent->getId();
          $salida['id'] = $mdDynamicContent->getId();
          $salida['className'] = $mdDynamicContent->getObjectClass();          
        }
        else
        {
            $body = $this->getPartial('addMdDynamic', array('form' => $form));
            $salida ['result'] = 0;
            $salida ['body'] = $body;
        }
        return $this->renderText(json_encode($salida));
    }
	
    public function executeGetDetailAjax(sfWebRequest $request) {
        $mdDynamicContent = Doctrine::getTable('mdDynamicContent')->find($request->getParameter('mdObjectId'));
        $form = new mdDynamicContentForm($mdDynamicContent);
        $salida = array();
        $body = $this->getPartial('openMdObject', array('form'=> $form));
        $returnType = 0;
        if (!$mdDynamicContent) {
            $returnType = 1;
        }
        $salida ['result'] = $returnType;
        $salida ['body'] = $body;
        $salida['id'] = $mdDynamicContent->getId();
        $salida['className'] = 'mdDynamicContent';
        return $this->renderText(json_encode($salida));
    }

    public function executeGetSmallDetailAjax(sfWebRequest $request) {
        $md_object = Doctrine::getTable('mdDynamicContent')->find($request->getParameter('mdObjectId'));
        $salida = array();
        $body = $this->getPartial('closedMdContent', array('md_object' => $md_object));
        $salida ['result'] = 0;
        $salida ['body'] = $body;
        $salida ['mdObjectId'] = $request->getParameter('mdObjectId');
        return $this->renderText(json_encode($salida));
    }

    public function executeSaveProfileAjax(sfWebRequest $request)
    {
        $parameters = $request->getPostParameters();
        $md_object = Doctrine::getTable('mdDynamicContent')->find($parameters['mdObjectId']);
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
            $this->clearCache($md_object->getId());
            return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
        }
        else
        {
            $profile = Doctrine::getTable("mdProfile")->find($values['mdProfileId']);
            $body = $this->getPartial('mdDynamicContent/profile_form', array('form'=>$form,'name'=> $profile->getName(), 'mdProfileId' => $profile->getId(), 'mdObjectId' => $parameters['mdObjectId'] ));
            return $this->renderText(mdBasicFunction::basic_json_response(false, array('profileId'=>$profile->getId(), 'body'=>$body)));
        }

    }

    public function executeDeleteMdContentAjax(sfWebRequest $request)
    {
        $salida = array();
        try{

            $md_content = Doctrine::getTable('mdDynamicContent')->find(array($request->getParameter('id')));
            $md_content->delete();

            $salida['response'] = 'OK';
            return $this->renderText(json_encode($salida));

        }catch(Exception $e){
            $salida['response'] = 'ERROR';
            $salida['mensaje'] = $e->getMessage();
            return $this->renderText(json_encode($salida));
        }
    }

    public function executeProcessMdObjectAjax(sfWebRequest $request)
    {
        $salida = array();
        $parameters = $request->getPostParameters();
        $mdDynamicContent = Doctrine::getTable('mdDynamicContent')->find($parameters['md_dynamic_content']['id']);
        $form = new mdDynamicContentForm($mdDynamicContent);
        $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
        $salida = array();
        if ($form->isValid())
        {
            $form->save();
            $salida['response'] = 'OK';
            $salida['options']  = array('_MD_OBJECT_ID' => $parameters['md_dynamic_content']['id']);
            $this->clearCache($parameters['md_dynamic_content']['id']);
        }
        else
        {
            $salida['response'] = 'ERROR';
            $salida['options']  = array('_MD_BODY' => $this->getPartial('openMdObject', array('form'=> $form)));
        }
        return $this->renderText(json_encode($salida));
    }

    private function clearCache($id)
    {
      $cacheManager = $this->getContext()->getViewCacheManager();
      if($cacheManager)
      {
        $cacheManager->remove('@sf_cache_partial?module=mdDynamicContent&action=__closed_box&sf_cache_key=mdDynamicContent_'.$id);
      }
    }
    
    public function executeDynamicFilter(sfWebRequest $request)
    {
      //print_r($request->getPostParameters());
      //die;
      $this->typeName = $request->getParameter('typeName', NULL);
      $this->formFilter = new mdDynamicContentFormFilter(array($this->typeName));

      $this->formFilter->bind($request->getParameter('md_dynamic_content_filters'));
      
      if ($this->formFilter->isValid()){
          $this->search = $this->formFilter->buildQuery($this->formFilter->getValues());
      } else {
          echo 'no valido ' . $this->formFilter->getErrorSchema() ;
      }

      
      
      $this->pager = new sfDoctrinePager ( 'mdDynamicContent', sfConfig::get ( 'app_max_shown_dynamic', 10 ) );
      $this->pager->setQuery ( $this->search );
      $this->pager->setPage ( $request->getParameter ( 'page', 1 ) );
      $this->pager->init();
      //$this->formFilter = new mdDynamicContentFormFilter(array($this->typeName));
      $this->isFiltered = true;
      
      $this->setTemplate('index');
    }


    /**
     * Funciones Open, closed y add, controlan el contenido
     * que se ve en el accordion
     *
     */
    public function executeOpenBox(sfWebRequest $request){
       $md_object = Doctrine::getTable('mdDynamicContent')->find($request->getParameter('id'));
       $form = new mdDynamicContentForm($md_object);
       $body = $this->getPartial('openMdObject', array('form'=> $form));
        return $this->renderText(json_encode(array(
            'content' => $body,
            'id' => $md_object->getId(),
            'className' => $md_object->getObjectClass()
        )));
   }

    public function executeClosedBox(sfWebRequest $request){
        $md_object = Doctrine::getTable('mdDynamicContent')->find($request->getParameter('id'));

        $body = $this->getPartial('closed_box', array('object' => $md_object));
        
        return $this->renderText(json_encode(array(
            'content' => $body
        )));
    }

    public function executeAddBox(sfWebRequest $request){
        return $this->renderText(json_encode(array(
            'content' => $this->getAddNewPartial($request->getParameter('typeName', NULL))
        )));
    }

    private function getAddNewPartial($typeName)
    {
      if(!($typeName))
      {
        return $this->retrieveNonTypeNameAddMdDynamicContent();
      }
      else
      {
        return $this->retrieveTypeNameAddMdDynamicContent($typeName);
      }
    }

    private function saveContent($request)
    {
        try{
            $postParamenters = $request->getPostParameter('md_dynamic_content');
            $hasProfile = false;
            $mdDynamicContent = new mdDynamicContent();
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
                      $mdDynamicContent->addTmpArrayMdProfileId($secondParam['mdProfileId']);
                      $mdAttributeParameters[$secondParam['mdProfileId']] = $secondParam;
                    }
                  }
                }
              }
            }
            if ($hasProfile)
            {
              $mdDynamicContent->setEmbedProfile(true);
              $mdDynamicContent->setTmpMdAttributesValues($mdAttributeParameters);
              if(sfConfig::get('sf_plugins_dynamic_manage'))
              {
                if(count($mdDynamicContent->getTmpArrayMdProfileId()) == 1)
                {
                  $arrayAux = $mdDynamicContent->getTmpArrayMdProfileId();
                  $configuration = contentHandler::getInstance()->retrieveConfigurationByMdProfileId(contentHandler::DYNAMIC_CONTENT, $arrayAux[0]);
                  $mdDynamicContent->setTypeName($configuration['typeName']);
                }
              }
            }
            else
            {
                $mdDynamicContent->setEmbedProfile(false);
            }
            $salida = array();

            $form = new mdDynamicContentForm($mdDynamicContent);
            $form->bind($this->request->getParameter($form->getName()), $this->request->getFiles($form->getName()));
            $salida = array();
            
            if ($form->isValid())
            {
                
            
                //Obtenemos el usuario logueado
                $mdUserId = $this->getUser()->getMdUserId();
                $form->getObject()->setMdUserIdTmp($mdUserId);
                $form->save();
            }
            else
            {
                //print_r($form->getFormattedErrors());
            }

        }catch(Exception $e)
        {
            throw $e;
        }
        
        return $form;
    }

    public function executeCreateDynamicContentRelation(sfWebRequest $request)
    {
        try
        {
            $_MD_Object_Id = $request->getParameter('_MD_Object_Id');

            $_MD_Object_Class_Name = $request->getParameter('_MD_Object_Class_Name');

            if($_MD_Object_Id == "" || $_MD_Object_Class_Name == "")
            {
                throw new Exception("wrong _MD_Object_Id or _MD_Object_Class_Name", 100);
            }

            $form = $this->saveContent($request);

            if ($form->isValid())
            {
                $mdDynamicContent = $form->getObject();

                $mdContentConcreteOwner = Doctrine::getTable($_MD_Object_Class_Name)->find($_MD_Object_Id);

                // CHECK: Esto se podria haber hecho asi: $mdContentConcreteOwner->retrieveMdContent()->addContent($mdDynamicContent->retrieveMdContent());
                mdContentRelation::addContent($mdContentConcreteOwner->retrieveMdContent(), $mdDynamicContent->retrieveMdContent(), $mdDynamicContent->getTypeName());

                $mdDynamicContent->setEmbedProfile(false);

                $return = array('response' => 'OK', 'id' => $mdDynamicContent->getId(), 'className' => $mdDynamicContent->getObjectClass(), 'body' => $this->getPartial('editMdDynamicRelation', array('form' => new mdDynamicContentForm($mdDynamicContent))));
            }
            else
            {
		$mdContentConcreteOwner = Doctrine::getTable($_MD_Object_Class_Name)->find($_MD_Object_Id);
                $return = array('response' => 'ERROR', 'body' => $this->getPartial('mdDynamicContent/addMdDynamicRelation', array('form' => $form, '_MD_Content_Concrete_Owner' => $mdContentConcreteOwner)));
            }
        }catch(Exception $e){

            $return = array('response' => 'ERROR', 'body' => "<p>".$e->getMessage()."</p>");

        }

        return $this->renderText(json_encode($return));
    }
    
    
    public function executeChangePriority(sfWebRequest $request)
    {
      $mdDynamicId = $request->getParameter('mdDynamicId');

      $value = $request->getParameter('value');
      
      $priority = mdDynamicContent::changePriority($mdDynamicId, $value);
      $salida = array();
      $salida['priority'] = $priority;
      return $this->renderText(json_encode($salida));
    }
}
