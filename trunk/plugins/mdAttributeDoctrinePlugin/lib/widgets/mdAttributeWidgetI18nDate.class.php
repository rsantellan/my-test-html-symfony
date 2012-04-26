<?php

class mdAttributeWidgetI18nDate extends mdAttribute implements iMdAttribute {

    private $value = null;
    private $attValueId = null;

    public function getWidget() {

        $monthFormat = sfConfig::get('sf_plugins_attribute_monthFormat', 'number');
        $maxYear = sfConfig::get('sf_plugins_attribute_yearStart', '100');
        $minYear = sfConfig::get('sf_plugins_attribute_yearEnd', '0');

        $year_start = date('Y', strtotime('-' . $maxYear . ' years'));
        $year_end = date('Y', strtotime('+' . $minYear . ' years'));

        $ascending  = ($year_start < $year_end);
        $until_year = ($ascending) ? $year_end + 1 : $year_end - 1;

        for ($x = $year_start; $x != $until_year; ($ascending) ? $x++ : $x--)
        {
            $years[$x] = $x;
        }
        
        if (is_array($this->value)) {
            if (sfContext::hasInstance ()) {

                return new mdWidgetFormI18nDate(array(
                    'culture' => sfContext::getInstance ()->getUser()->getCulture(),
                    'default' => time(),
                    'years' => $years,
                    'month_format' => $monthFormat,
                    'value' =>$this->value,
                    'label'=>$this->getLabel(),
                    'format' => '%day% %month% %year%',
                        )
                );
            } else {

                return new mdWidgetFormI18nDate(array(
                    'culture' => sfConfig::get('sf_default_culture'),
                    'default' => time(),
                    'years' => $years,
                    'month_format' => $monthFormat,
                    'value' =>$this->value,
                    'label'=>$this->getLabel(),
                    'format' => '%day% %month% %year%',
                        ));
            }
        } else {
            if (sfContext::hasInstance ()) {

                return new mdWidgetFormI18nDate(array(
                    'culture' => sfContext::getInstance ()->getUser()->getCulture(),
                    'default' => time(),
                    'years' => $years,
                    'month_format' => $monthFormat,
                    'label'=>$this->getLabel(),
                    'format' => '%day% %month% %year%',
                        )
                );
            } else {

                return new mdWidgetFormI18nDate(array(
                    'culture' => sfConfig::get('sf_default_culture'),
                    'default' => time(),
                    'years' => $years,
                    'month_format' => $monthFormat,
                    'label'=>$this->getLabel(),
                    'format' => '%day% %month% %year%',
                        ));
            }
        }
    }

    public function getValidator() {
        $requiered = false;
        if ($this->getRequiered()) {
            $requiered = true;
        }

        return new sfValidatorDate();
    }

    public function setParentAttributes($parent) {
        $this->setId($parent->getId());
        $this->setName($parent->getName());
        $this->setLabel($parent->getLabel());
        $this->setRequiered($parent->getRequiered());
        $this->setTypeClass($parent->getTypeClass());
        $this->setTranslated($parent->getTranslated());
    }

    public function setValue($value) {
        $dateArray = explode("-", $value);
        
        $valueDateArray = array();
        $valueDateArray['year'] = $dateArray[0];
        $valueDateArray['month'] = $dateArray[1];
        $valueDateArray['day'] = $dateArray[2];
        $culture;
        if (sfContext::hasInstance ()) {
            $culture = sfContext::getInstance ()->getUser()->getCulture();
        } else {
            $culture = sfConfig::get('sf_default_culture');
        }
        $this->value = $valueDateArray; // date("M-d-Y", mktime(0, 0, 0, 12, $dateArray[0], 1997));
    }

    public function isMultiple() {
        return false;
    }

    public function isValueDependent() {
        return false;
    }

    public function setMyMdAttributeValueId($id) {
        $this->attValueId = $id;
    }

    public function isDateWidget() {
        return true;
    }

    public function isCheckBox(){
        return false;
    }

}
