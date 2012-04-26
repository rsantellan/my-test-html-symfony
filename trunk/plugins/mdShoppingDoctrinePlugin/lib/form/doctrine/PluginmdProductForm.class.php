<?php

/**
 * mdProduct form.
 *
 * @package    mdShoppingPlugin
 * @subpackage form
 * @author     Rodrigo Santellan
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PluginmdProductForm extends BasemdProductForm {

	public function setup()
  	{
            parent::setup();

            unset ($this['category_list']);
            $this->validatorSchema['price'] = new sfValidatorI18nFloat();
            $this->validatorSchema['tax'] = new sfValidatorI18nFloat();

            $this->widgetSchema['price'] = new mdWidgetFormInputI18nCurrency();
            $this->widgetSchema['tax'] = new mdWidgetFormInputI18nCurrency();

            $this->embedI18n ( array ( sfContext::getInstance()->getUser()->getCulture()) );

            $this->widgetSchema['id'] = new sfWidgetFormInputHidden();
            $this->widgetSchema['md_currency_id'] = new sfWidgetFormInputHidden(array('default' => sfConfig::get('sf_plugins_products_default_currency', 1)));

            //embebo el form de los atributos de la clase
            $mdAttributesForms = $this->getObject()->retrieveAllAttributesForm();
            //print_r(count($mdAttributesForms));
            $myForm = new sfForm();

            foreach($mdAttributesForms as $mdAttributesForm){
                $myForm->embedForm ( $mdAttributesForm->getName(), $mdAttributesForm);
            }

            $this->embedForm('mdAttributes', $myForm);
  	}

    public function save($con = null) {
            $tainted = $this->getTaintedValues ();

            if($this->getObject ()->getEmbedProfile()){
                $attributesValues = $tainted ['mdAttributes'];
                unset($this ['mdAttributes'], $tainted ['mdAttributes']);
            }

            //Salvo el mdUsercontent
            $mdProduct = parent::save ();

            if($this->getObject()->getEmbedProfile())
            {
                $mdAttributesForms = $this->getObject()->retrieveAllAttributesForm ();

                foreach($mdAttributesForms as $tmpForm)
                {
                    $form_values = $attributesValues[$tmpForm->getName ()];
                    $form_values [$tmpForm->getCSRFFieldName ()] = $tmpForm->getCSRFToken ();
                    $tmpForm->bind ( $form_values );
                    if ($tmpForm->isValid ())
                    {
                        //Al ser valido lo salvo
                        $mdProduct->saveAllAttributes ( $tmpForm );
                    }
                }
            }

            return $mdProduct;
	}
}
