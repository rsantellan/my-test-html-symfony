<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class mdAttributeManagementActions extends sfActions {
  
  public function executeAddAttributeOption(sfWebRequest $request)
  {
    $label = $request->getParameter("label");
    $value = $request->getParameter("value");
    $mdAttribute = Doctrine::getTable("mdAttribute")->findOneBy("name", $label);
    if($mdAttribute)
    {
        $mdAttributeValue = new mdAttributeValue();
        $mdAttributeValue->setMdAttribute($mdAttribute);
        $mdAttributeValue->setName($value);
        $mdAttributeValue->save();
        return $this->renderText(mdBasicFunction::basic_json_response(true, array('id'=>$mdAttributeValue->getId())));
    }
    else
    {
        return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
    }
  }
}
