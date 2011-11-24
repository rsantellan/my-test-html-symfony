<?php
class searchForm extends sfForm
{
  
  public function configure()
  {
    $this->disableLocalCSRFProtection();
    $this->setWidgets(array(
        'nombre'    => new sfWidgetFormInput(array(), array('label' => 'Nombre'))
    ));

    $error_message = array(
            'required'=>'Requerido.',
            'invalid' => 'Email invalido.'
            );

    $this->setValidators(array(
        'nombre'    => new sfValidatorString(array('required' => false),$error_message)        
    ));

    $this->widgetSchema->setNameFormat('%s');

  }

    
}
