<?php

//Constants : Defined during compile time
const SUCCESS = 1;
const FAILURE = 0;

//Define : Defined during run time
define('FORMAT_DATE', 'M j, Y');
define('FORMAT_TIME', 'g:i A');
define('FORMAT_DATETIME', FORMAT_DATE . ' ' . FORMAT_TIME); //'l jS \\of F Y h:i:s A' = Friday 11th of October 2019 02:16:04 AM

return [
    'options' =>    [
        'page_size' => '10',
    ]
];
