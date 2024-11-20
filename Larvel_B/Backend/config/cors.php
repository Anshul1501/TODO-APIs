<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Laravel CORS Configuration
    |--------------------------------------------------------------------------
    |
    | Define the settings for Cross-Origin Resource Sharing (CORS). These
    | settings determine what cross-origin operations are allowed to execute
    | in web browsers.
    |
    */

    'paths' => ['api/*', 'sanctum/csrf-cookie'],

    'allowed_methods' => ['*'], // Allow all HTTP methods

    'allowed_origins' => ['*'], // Allow all origins, replace with specific URLs if needed

    'allowed_origins_patterns' => [], // Allow origins matching specific patterns

    'allowed_headers' => ['*'], // Allow all headers

    'exposed_headers' => [], // Headers exposed to the browser

    'max_age' => 0, // Maximum age for CORS preflight requests

    'supports_credentials' => true, // Set to true if credentials (cookies, etc.) are allowed

  /*
  'paths' => ['api/*', 'sanctum/csrf-cookie'],
'allowed_methods' => ['*'],
'allowed_origins' => ['http://localhost:5173'],
'allowed_headers' => ['*'],
'exposed_headers' => [],
'max_age' => 0,
'supports_credentials' => false,

  */

];
