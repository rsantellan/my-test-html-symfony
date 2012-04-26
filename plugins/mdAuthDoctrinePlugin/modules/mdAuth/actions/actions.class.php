<?php

/**
 * mdUserContent actions.
 *
 * @package    combaGol
 * @subpackage mdAuth
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdAuthActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {
        $this->loginForm = new mdUserContentLoginForm ( );
    }

    public function executeSignin(sfWebRequest $request) {

        if($request->getParameter('postLogin') != '')
        {
            $automaticUriToGo = $request->getParameter('postLogin');
        }
        else
        {
            $automaticUriToGo = $request->getReferer();
        }

        $this->form = new mdPassportLoginForm ( );

        if ($request->isMethod('post')) {
            $this->form->bind($request->getParameter($this->form->getName()));
            if ($this->form->isValid()) {

                $values = $this->form->getValues();
                try {
                    $user = mdPassport::getCheckedPassportByUserOrPassword($values ['username'], $values ['password']);
                    $this->getUser()->signin($user, $values ['remember']);
                    mdUserLoginHandler::checkRequieredProfiles($user, sfContext::getInstance()->getConfiguration()->getApplication());
                    // authenticate user and redirect them
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->addCredential('user');
                    $uri = "";
                    try {
                        if ($automaticUriToGo && strpos($automaticUriToGo, 'signin') === false) {
                            $uri = $automaticUriToGo;
                        } else {
                            $uri = $request->getPostParameter('uriToGo', '@homepage');
                        }
                    } catch (Exception $e) {
                        $uri = $request->getPostParameter('uriToGo', '@homepage');
                    }

                    $this->redirect($uri);
                    return true;
                } catch (Exception $e) {
                    switch ($e->getCode()) {
                        case PluginmdPassport::INVALID_USER:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::INVALID_PASSWORD:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::INVALID_PASSPORT:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::NOT_ACTIVE:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::NOT_REQUIERED_GROUPS:
                            $this->exception = $e->getMessage();
                            break;
                    }
                }
            }
        }
    }

    public function executeSigninAjax(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new mdPassportLoginForm ( );
        $body = $this->getPartial('mdAuth/smallSigninAjax', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeProcesSigninAjax(sfWebRequest $request) {
        $ok = false;
        if ($request->isMethod('post')) {
            $this->exception = '';
            $this->form = new mdPassportLoginForm ( );
            $this->form->bind($request->getParameter($this->form->getName()));

            if ($this->form->isValid()) {
                $values = $this->form->getValues();
                try {
                    $user = mdPassport::getCheckedPassportByUserOrPassword($values ['username'], $values ['password']);
                    mdUserLoginHandler::checkRequieredProfiles($user, sfContext::getInstance()->getConfiguration()->getApplication());
                    $this->getUser()->signin($user, $values ['remember']);
                    // authenticate user and redirect them
                    $this->getUser()->setAuthenticated(true);
                    $this->getUser()->addCredential('user');
                    $ok = true;
                } catch (Exception $e) {
                    switch ($e->getCode()) {
                        case PluginmdPassport::INVALID_USER:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::INVALID_PASSWORD:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::INVALID_PASSPORT:
                            $this->exception = $e->getMessage();
                            break;
                        case PluginmdPassport::NOT_ACTIVE:
                            $this->exception = $e->getMessage();
                            break;                        
                        default:
                            $this->exception = $e->getMessage();
                    }
                }
            }
        }

        $salida = array();
        if ($ok) {
            $salida ['result'] = 0;
            $salida ['body'] = 'ok';
        } else {
            $body = $this->getPartial('mdAuth/smallSigninAjax', array('form' => $this->form, 'exception' => $this->exception));
            $salida ['result'] = 1;
            $salida ['body'] = $body;
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeForgotPassword(sfWebRequest $request) 
    {
      $this->isAjax = $request->getParameter("ajax");
      if($this->isAjax == "1")
      {
        $this->setLayout(false);
      }
      $this->exception = '';
      $this->form = new emailForm( );
      //$body = $this->getPartial('mdAuth/forgotPassword', array('form' => $this->form, 'exception' => $this->exception));
      //return $this->renderText(mdBasicFunction::basic_json_response(true, array('body' => $body));
    }
    
    public function executeProccesForgotPasswordAjax(sfWebRequest $request) 
    {
      $form = new emailForm( );
      $form->bind($request->getParameter($form->getName()));
      $isAjax = 1;
      $response = false;
      if ($form->isValid()) 
      {
        $email = $form->getValue('email');
        $mdUser = mdUserHandler::retrieveMdUserByEmail($email);
        if(!$mdUser)
        {
          $response = false;
          sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
          $exception = __("usuario_el email no existe");
          $body = $this->getPartial('mdAuth/forgotPassword', array('form' => $form, 'exception' => $exception, 'isAjax' => $isAjax));
        }
        else
        {
          $response = true;
          mdMailHandler::sendConfirmationMail(mdUserHandler::retrieveMdPassportWithMdUserId($mdUser->getId()));
          sfContext::getInstance()->getConfiguration()->loadHelpers(array('I18N'));
          $body = __("usuario_el email se ha enviado con exito.");
        }
        
        
      } 
      else
      {
        $exception = "";
        $body = $this->getPartial('mdAuth/forgotPassword', array('form' => $form, 'exception' => $exception, 'isAjax' => $isAjax));
      }    
      
      return $this->renderText(mdBasicFunction::basic_json_response($response, array('body' => $body))); 
    }
/*
    public function executeForgotPassword(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new emailForm( );
        $body = $this->getPartial('mdAuth/forgotPassword', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }
*/
    public function executeGetResetUserPasswordAjax(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new emailForm( );
        $body = $this->getPartial('mdAuth/forgotPassword', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeResetUserPasswordAjax(sfWebRequest $request) {

        try {
            $salida = array();
            $mdPassport = Doctrine::getTable('mdPassport')->find($request->getPostParameter('mdUserContentId'));
            if ($mdPassport->resetPassword()) {
                //Mandar el mail
                mdMailHandler::sendConfirmationMail($mdPassport);
                $salida ['result'] = 0;
                $salida ['body'] = 'Mando el mail';
            } else {
                $salida ['result'] = 1;
                $salida ['body'] = 'No ok';
            }
        } catch (Exception $e) {
            $salida ['result'] = 1;
            $salida ['body'] = 'No ok: ' . $e->getMessage();
        }
        return $this->renderText(json_encode($salida));
    }

    public function executeGetActiveAccountEmail(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new emailForm( );
        $body = $this->getPartial('mdAuth/resendActivationEmail', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeProcessActiveAccountEmail(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new emailForm ( );
        $salida = array();
        $this->form->bind($request->getPostParameters());
        if ($this->form->isValid()) {
            $data = $request->getPostParameters();
            $mdPassport = mdUserHandler::retrieveMdPassportWithMdUserEmail($data['email']);
            if ($mdPassport) {
                mdMailHandler::sendConfirmationMail($mdPassport);
                $body = 'Se ha enviado el mail';
                $salida ['result'] = 0;
                die('Se tiene que haber mandado el mail');
            } else {
                $this->exception = 'No hay usuario con ese email';
                $salida ['result'] = 1;
                $body = $this->getPartial('mdAuth/resendActivationEmail', array('form' => $this->form, 'exception' => $this->exception));
            }
        } else {
            $body = $this->getPartial('mdAuth/resendActivationEmail', array('form' => $this->form, 'exception' => $this->exception));
            $salida ['result'] = 1;
        }

        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeResetPassword(sfWebRequest $request) {
        if( sfConfig::get( 'sf_plugins_auth_remove_reset_layout', false ) )
        {
            $this->setLayout(false);
        }
        $this->form = new emailForm ( );
        if($request->isMethod('post')){
          $this->form->bind($request->getParameter($this->form->getName()));
          if ($this->form->isValid()) {
              $values = $this->form->getValues();
              $email = $values ['email'];
              $mdPassport = mdUserHandler::retrieveMdPassportWithMdUserEmail($email);
              if ($mdPassport) {
                  mdMailHandler::sendConfirmationMail($mdPassport);
              } else {
                  $this->exception = 'No hay usuario con ese email';
              }
          }
        }
    }

    public function executeResetPasswordAjax(sfWebRequest $request) {
        $this->exception = '';
        $this->form = new emailForm ( );
        $this->form->bind($request->getParameter($this->form->getName()));
        if ($this->form->isValid()) {
            $values = $this->form->getValues();
            $email = $values ['email'];
            $mdPassport = mdUserHandler::retrieveMdPassportWithMdUserEmail($email);
            if ($mdPassport) {
                mdMailHandler::sendConfirmationMail($mdPassport);
            } else {
                    $this->exception = 'No hay usuario con ese email';
            }
        }
        $body = $this->getPartial('mdAuth/forgotPassword', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(json_encode($salida));
    }

    public function executeSecure(sfWebRequest $request) {
        $this->getResponse()->setStatusCode(403);
    }

    public function executeLogout() {
        if($this->getUser()->isAuthenticated())
        {
            $this->getUser()->signOut();
            if($this->getUser()->hasAttribute('cart')) $this->getUser()->setAttribute('cart', null);
        }
        return $this->redirect('@homepage');
    }

/*
    public function executeChangePasswordAjax(sfWebRequest $request) {
        $this->form = new PasswordChangeForm();
        $this->exception = '';
        $body = $this->getPartial('mdAuth/changePassword', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(mdBasicFunction::basic_json_response(true, $salida));
        
    }

    public function executeProccesChangePasswordAjax(sfWebRequest $request) {
        $this->form = new PasswordChangeForm();
        
        $this->exception = '';
        $this->form->bind($request->getParameter($this->form->getName()));
        if($this->form->isValid()){
            $mdPassport = $this->getUser()->getMdPassport();
            $values = $request->getParameter($this->form->getName());
            
            $mdPassport->changePassword($values['password']);
            $body = $this->getPartial('mdAuth/changePasswordCorrect');
            $salida ['result'] = 1;
            $salida ['body'] = $body;
            return $this->renderText(mdBasicFunction::basic_json_response(true, $salida));
        }else{
            $this->exception = "Las contraseña ingresadas son distintas";
            $body = $this->getPartial('mdAuth/changePassword', array('form' => $this->form, 'exception' => $this->exception));
            $salida ['result'] = 1;
            $salida ['body'] = $body;
            return $this->renderText(mdBasicFunction::basic_json_response(false, $salida));
        }
    }
*/ 
/*
    public function executeChangeEmailAjax(sfWebRequest $request) {
        $this->form = new emailForm();
        $this->exception = '';
        $body = $this->getPartial('mdAuth/changeEmail', array('form' => $this->form, 'exception' => $this->exception));
        $salida ['result'] = 1;
        $salida ['body'] = $body;
        return $this->renderText(mdBasicFunction::basic_json_response(true, $salida));
    }
*/

}
