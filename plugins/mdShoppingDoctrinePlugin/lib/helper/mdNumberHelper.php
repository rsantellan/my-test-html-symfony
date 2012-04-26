<?php
function formatNumber($value) {
    return number_format(round($value, (int) sfConfig::get("app_rounding", 2)), 2, '.', '');
}