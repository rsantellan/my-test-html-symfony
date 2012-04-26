<?php

/**
 * mdUser form.
 *
 * @package    mdBasicPlugin
 * @subpackage form
 * @version    0.3
 * @author Rodrigo Santellan
 */
class mdPassportLoginUserForm extends sfForm {

    public function configure() {
        $this->setWidgets(
                array(
                    'email' => new sfWidgetFormInput ( ),
                    'password' => new sfWidgetFormInputPassword ( ),
                    'username' => new sfWidgetFormInput ( ),
                    'name' => new sfWidgetFormInput ( ),
                    'last_name' => new sfWidgetFormInput ( )
                )
        );

        $this->widgetSchema->setNameFormat('login[%s]');

        $this->setValidators(
                array(
                    'email' => new sfValidatorEmail(
                            array(
                                'required' => true
                            )
                    ),
                    'username' => new sfValidatorString(
                            array(
                                'required' => true
                            )
                    ),
                    'password' => new sfValidatorString(
                            array(
                                'required' => true
                            )
                    ),
                    'name' => new sfValidatorString(
                            array(
                                'required' => true
                            )
                    ),
                    'last_name' => new sfValidatorString(
                            array(
                                'required' => true
                            )
                    )
                )
        );
        $this->widgetSchema ['password_confirmation'] = new sfWidgetFormInputPassword ( );
        $this->validatorSchema ['password_confirmation'] = clone $this->validatorSchema ['password'];

        $this->widgetSchema->moveField('password_confirmation', 'after', 'password');

        $this->mergePostValidator(new sfValidatorSchemaCompare('password', sfValidatorSchemaCompare::EQUAL, 'password_confirmation', array(), array('invalid' => 'The two passwords must be the same.')));

        $this->widgetSchema->setNameFormat('md_passport_login_no_user[%s]');

        $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);
    }

    public function isValid() {
        if (parent::isValid ()) {
            $tainted = $this->getTaintedValues();
            mdUser::validateEmail($tainted['email']);
            mdPassport::validateUserName($tainted['username']);
            return true;
        }
        return false;
    }

    public function save($con = null) {
        $tainted = $this->getTaintedValues();

        $mdUser = new MdUser();
        $mdUser->setEmail($tainted['email']);
        $mdUser->save();
        $mdPassport = new mdPassport();
        $mdPassport->setMdUser($mdUser);
        $mdPassport->setUsername($tainted['username']);
        $mdPassport->setPassword($tainted['password']);
        $mdPassport->save();
        $mdUserProfile = new mdUserProfile();
        $mdUserProfile->setName($tainted['name']);
        $mdUserProfile->setLastName($tainted['last_name']);
        $mdUserProfile->setMdUserIdTmp($mdUser->getId());
        $mdUserProfile->save();
        return $mdPassport;
    }

}
