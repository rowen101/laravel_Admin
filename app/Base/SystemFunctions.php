<?php

namespace App\Base;

if (!function_exists('setTimeZone')) {
    /**
     * sets the current timezone
     * */
    function setTimeZone($valid_timezone_identifier) {
        return date_default_timezone_set($valid_timezone_identifier);
    }
}

// Function for basic field validation (present and neither empty nor only white space
function IsNullOrEmptyString($str) {
    return (!isset($str) || trim($str) === '');
}
