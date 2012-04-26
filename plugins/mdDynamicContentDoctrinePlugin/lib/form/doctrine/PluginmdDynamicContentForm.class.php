<?php

/**
 * mdDynamicContent form.
 *
 * @package    aeromarket
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdDynamicContentForm extends BasemdDynamicContentForm
{

    public function setup()
    {
        parent::setup();

        unset($this['created_at'], $this['updated_at'], $this['type_name'], $this['priority']);

        $this->widgetSchema['publish_at'] = new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d H:i:s'), 'useTimeWidget' => true));

        $this->validatorSchema['publish_at'] = new sfExtraValidatorDatepickerTime();

        $this->widgetSchema['publish_up_to'] = new sfWidgetFormInputDatepicker(array('default' => date('Y-m-d H:i:s'), 'useTimeWidget' => true));

        $this->validatorSchema['publish_up_to'] = new sfExtraValidatorDatepickerTime();

        $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

        $myForm = new sfForm();

        foreach($mdAttributesForms as $tmpForm)
        {
            $myForm->embedForm ( $tmpForm->getName (), $tmpForm );
        }

        $this->embedForm('mdAttributes', $myForm);
    }


    public function save($con = null)
    {
        $tainted = $this->getTaintedValues ();

        if($this->getObject ()->getEmbedProfile())
        {
            $attributesValues = $tainted ['mdAttributes'];
            unset ( $this ['mdAttributes'], $tainted ['mdAttributes'] );
        }

        $mdDynamicContent = parent::save($con);

        if($this->getObject ()->getEmbedProfile())
        {
            $mdAttributesForms = $this->getObject ()->retrieveAllAttributesForm ();

            foreach($mdAttributesForms as $tmpForm)
            {
                $form_values = $attributesValues[$tmpForm->getName ()];
                $form_values [$tmpForm->getCSRFFieldName ()] = $tmpForm->getCSRFToken ();
                $tmpForm->bind ( $form_values );
                if ($tmpForm->isValid ())
                {
                    //Al ser valido lo salvo
                    $mdDynamicContent->saveAllAttributes ( $tmpForm );
                }
            }
        }

        return $mdDynamicContent;
    }

}
