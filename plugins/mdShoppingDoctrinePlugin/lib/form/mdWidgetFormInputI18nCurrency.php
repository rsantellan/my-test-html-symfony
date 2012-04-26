<?php

class mdWidgetFormInputI18nCurrency extends sfWidgetFormInput {
    protected function configure($options = array(), $attributes = array())
    {
        parent::configure($options, $attributes);

        $this->setOption('type', 'text');
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        if($value != null)
        {
            $value = mdBasicFunction::i18n_value_replace($value, sfContext::getInstance()->getUser()->getCulture());
        }

        return $this->renderTag('input', array_merge(array('type' => $this->getOption('type'), 'name' => $name, 'value' => $value), $attributes));
    }


}