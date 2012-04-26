<?php

/**
 * mdUser form.
 *
 * @package    mdBasicPlugin
 * @subpackage form
 * @author     Your name here
 * @version    0.2
 * @author Rodrigo Santellan
 */
class PasswordChangeForm extends sfForm {

    public function configure() {
        $this->setWidgets(
                array(
                    'old_password' => new sfWidgetFormInputPassword ( ),
                    'password' => new sfWidgetFormInputPassword ( )
                )
        );

        $error_message = array(
          'required'=>'Requerido.',
          'invalid' => 'Email invalido.'
          );


        $this->setValidators(
                array(
                    'old_password' => new sfValidatorString(
                            array(
                                'required' => true
                            ),$error_message
                    ),
                    'password' => new sfValidatorString(
                            array(
                                'required' => true
                            ),$error_message
                    )
                )
        );

        $this->widgetSchema ['password_confirmation'] = new sfWidgetFormInputPassword ( );
        $this->validatorSchema ['password_confirmation'] = clone $this->validatorSchema ['password'];

        $this->widgetSchema->moveField('password_confirmation', 'after', 'password');

        $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array(), array('invalid' => 'The two passwords must be the same.')));

        $this->widgetSchema->setNameFormat('md_change_password[%s]');
        //$this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }

}
