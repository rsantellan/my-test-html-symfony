<?php

function jsFormattedArrayOfDates($str_dates){
    $arr_strings = array();
    $dates = explode(',', $str_dates);
    $arr_strings = '[';

    for($i=0; $i < count($dates); $i++){
        if($i != 0){
            $arr_strings .= ",";
        }
        $arr_strings .= "'".$dates[$i]. "'";
    }
    $arr_strings .= "]";

    return $arr_strings;
}