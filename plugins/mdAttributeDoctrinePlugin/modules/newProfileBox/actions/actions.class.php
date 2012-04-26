<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class newProfileBoxActions extends sfActions {
  
  public function executeGetProfiles(sfWebRequest $request) 
  {
    $salida = array();
    try
    {
      $objectId = $request->getParameter('objectId');
      $objectClass = $request->getParameter('objectClass');
      $mdProfiles = Doctrine::getTable('mdProfile')->retrieveAllMdProfilesNotBelongingToObject($objectId, $objectClass);
      $salida['body'] = $this->getPartial('select_profiles_list', array('mdProfiles' => $mdProfiles,'objectId' => $objectId, 'objectClass' => $objectClass));
      $salida['result'] = 0;      
    }
    catch(Exception $e)
    {
      $salida['result'] = 1;
      $salida['error'] = $e->getMessage();
    }

    return $this->renderText(json_encode($salida));
  }
  
  public function executeShowProfileAjax(sfWebRequest $request)
  {
    $salida = array();
    try
    {    
      $objectId = $request->getParameter('objectId');
      $objectClass = $request->getParameter('objectClass');
      $mdProfileId = $request->getParameter('mdProfileId');
      $handler = new mdAttributeHandler();
          
      $form = $handler->getAllAttributesForm($mdProfileId, $objectId, $objectClass);
      $salida['body'] = $this->getPartial('newProfileForm', array('mdProfileId' => $mdProfileId, 'form' => $form, 'objectId' => $objectId, 'objectClass' => $objectClass));
      $salida['result'] = 0;
    }
    catch(Exception $e)
    {
      $salida['result'] = 1;
      $salida['error'] = $e->getMessage();
    }
    return $this->renderText(json_encode($salida));
  }
  
  public function executeProccessNewProfile(sfWebRequest $request)
  {
    $salida = array();
    $salida['result'] = 1;
    $salida['body'] = "";
    $parameters = $request->getPostParameters();
    $mdObject = Doctrine::getTable($parameters['objectClass'])->find($parameters['objectId']);
    $mdProfileId =  $parameters['mdAttributes']['mdProfileId'];
    $form = $mdObject->getAttributesFormOfMdProfileById($mdProfileId);
    $form->bind($parameters['mdAttributes']);
    if($form->isValid()){
      $mdObject->saveAllAttributes($form);
      $mdObject->executeAddProfile($mdProfileId);
      $salida['result'] = 0;
    }else{
       $salida['body'] =$form->getFormattedErrors();
    }
    return $this->renderText(json_encode($salida));
  }
}
