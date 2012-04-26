<?php

/**
 * static actions.
 *
 * @package    frontend
 * @subpackage static
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 12479 2008-10-31 10:54:40Z fabien $
 */
class oneWidgetFormsActions extends sfActions {

    public function  executeSaveSingleForm($request) {
        $parameters = $request->getPostParameter('one_attribute_form');
        //print_r($parameters);
        $this->form = mdAttributeHandler::retrieveFormOfSingleAttribute($parameters['objectId'], $parameters['objectClass'], $parameters['mdProfileId'], $parameters['mdAttributeId']);
        $this->form->bind($parameters);
        if($this->form->isValid())
        {
            mdAttributeHandler::saveSingleAttributeForm($this->form);
            return $this->renderText(mdBasicFunction::basic_json_response(true, array()));
        }
        else
        {
            return $this->renderText(mdBasicFunction::basic_json_response(false, array()));
        }
        
    }
}
