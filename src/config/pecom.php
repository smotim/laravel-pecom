<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pecom Default configuration
    |--------------------------------------------------------------------------
    |
    | This options must be set in order to use Pecom API.
    |
    */

    'key'        => env('PECOM_KEY', null),
    'user'       => env('PECOM_USER', null),
    'prefix'     => 'pecom',
    'middleware' => ['web'],

];
