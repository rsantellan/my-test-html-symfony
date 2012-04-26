<?php

class  mdWidgetFormDatepickerMultiple extends sfWidgetFormInputHidden
{
    public function configure($options = array(), $attributes = array())
    {
        $this->addOption('culture', sfContext::getInstance()->getUser()->getCulture());
        $this->addOption('value', '');
        $this->addOption('selected', '[]');
        parent::configure($options, $attributes);
    }

    public function render($name, $value = null, $attributes = array(), $errors = array())
    {
        sfContext::getInstance()->getConfiguration()->loadHelpers('dapickerFormat');
        $arr_strings = jsFormattedArrayOfDates($this->getOption('value'));
        
        $div = '<div id="datepicker-multiple"></div>';
        $js = '<script>$(function()
            {
                var date = new Date();
                var month = date.getMonth() + 1;
                var today = date.getFullYear() +"-"+month+"-"+date.getDate();

                $("#datepicker-multiple").DatePicker({
                    flat: true,
                    date: '.$arr_strings.',
                    current: today,
                    calendars: 3,
                    mode: "multiple",
                    starts: 1,
                    onChange: function(formated, dates){
                    
                        var elem = document.getElementsByName("'.$name.'");
                        var formated_date_arr = new Array();

                        for(var i=0; i < dates.length; i++){
                            var month = dates[i].getMonth() + 1;
                            var date  = dates[i].getFullYear() +"-"+month+"-"+dates[i].getDate();
                            formated_date_arr.push(date);
                        }
                        var formated_dates = formated_date_arr.join(",");
                        $(elem).val(formated_dates);

                    }
                });



            });</script>';

            $value = $this->getOption('value');
        return parent::render($name, $value, $attributes, $errors). $div. $js;
    }

}