<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mdWidgetFormI18nDate
 *
 * @author rodrigo
 */
class mdWidgetFormI18nDate extends sfWidgetFormI18nDate {

    protected function configure($options = array(), $attributes = array()) {
        $this->addOption('value');
        parent::configure($options, $attributes);
    }

    public function getMyDateFormat($culture) {
        return parent::getDateFormat($culture);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array()) {
        $value = ($this->getOption('value') !== false || !$value || is_array($value)) ? $this->getOption('value') : $value;
        return parent::render($name, $value, $attributes, $errors);
    }

}

