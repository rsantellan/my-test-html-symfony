<?php

/**
 * mdUser form.
 *
 * @package    combaGol
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrinePluginFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class mdUserContentResetPasswordForm extends sfForm {
	public function configure() {
		$this->setWidgets ( 
						array (
								'id' => new sfWidgetFormInputHidden ( ), 
								'password' => new sfWidgetFormInputPassword ( ),
								'password_confirmation' => new sfWidgetFormInputPassword ( ) 
							) 
						);
		
		$this->widgetSchema->setNameFormat ( 'login[%s]' );
		
		$this->setValidators ( 
						array (
								'id' => new sfValidatorString ( 
									array (
										'required' => true
										) 
									), 
								'password' => new sfValidatorPass (
									array (
										'required' => true
										)
									),
								 'password_confirmation' => new sfValidatorPass(
									)
								) 
							);
		$this->mergePostValidator ( new sfValidatorSchemaCompare ( 'password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array (), array ('invalid' => 'The two passwords must be the same.' ) ) );
	}

}
