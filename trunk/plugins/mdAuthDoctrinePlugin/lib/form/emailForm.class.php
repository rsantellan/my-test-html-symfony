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
class emailForm extends sfForm {

    public function configure() {
        $defaults = $this->getDefaults();
        $email = "";
        if (isset($defaults) && isset($defaults['email'])) {
            $email = $defaults['email'];//$defaults;
        }
        $this->setWidgets(
                array(
                    'email' => new sfWidgetFormInputConfigurable (array("value"=>$email) )                    
                )
        );

        $this->setValidators(
                array(
                    'email' => new sfValidatorEmail(
                            array(
                                'required' => true
                            )
                    )
                )
        );
        $this->widgetSchema->setNameFormat('md_change_email[%s]');
    }

}
