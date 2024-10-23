<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default User Account Settings
    |--------------------------------------------------------------------------
    |
    | This file contains the default settings for user accounts in the application.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Super Admin Account
    |--------------------------------------------------------------------------
    */
    'super_admin' => [
        'email' => env('SUPER_ADMIN_EMAIL'),
        'password' => env('SUPER_ADMIN_PASSWORD'),
        'name' => env('SUPER_ADMIN_NAME'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Sub Admin Account
    |--------------------------------------------------------------------------
    */
    'sub_admin' => [
        'email' => env('SUB_ADMIN_EMAIL'),
        'password' => env('SUB_ADMIN_PASSWORD'),
        'name' => env('SUB_ADMIN_NAME', 'Sub Admin'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Default User Account
    |--------------------------------------------------------------------------
    */
    'user' => [
        'email' => env('TEST_USER_EMAIL'),
        'password' => env('TEST_USER_PASSWORD'),
        'name' => env('TEST_USER_NAME'),
    ],
];