<?php
/**
 * sfWidgetFormInput should really have a 'value' option. This class adds one.
 * 
 * @author al
 *
 */
class sfWidgetFormTinyEditorTextAreaConfigurable extends sfWidgetFormTextareaTinyMCE
{
  /**
   * Constructor.
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default  HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array()) 
  { 
    $this->addOption('value');
    $this->addOption('theme', 'advanced');
    $this->addOption('width');
    $this->addOption('height');
    $this->addOption('config', '');    
    parent::configure($options, $attributes);
  }


  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
		// maui: arreglo esto para que cuando retorna los errores deje lo que estaba equivocado
		//$value = ($this->getOption('value') !== false || !$value || is_array($value)) ? $this->getOption('value') : $value;
		$value = (($value === null and $this->getOption('value') !== false) || !$value || is_array($value)) ? $this->getOption('value') : $value;

		if(isset($attributes['class']))
		{
			$attributes['class'] = $attributes['class'].' textarea-with-tiny';
		}
		else
		{
			$attributes['class'] = 'textarea-with-tiny';
		}
		
    $textarea = parent::render($name, $value, $attributes, $errors);



    return $textarea;
  }
}
