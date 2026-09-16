<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'postex' => [
        'token' => env('POSTEX_API_TOKEN'),
        'base_url' => env('POSTEX_API_BASE_URL', 'https://api.postex.pk/services/integration/api/order'),
        'pickup_address_code' => env('POSTEX_PICKUP_ADDRESS_CODE'),
        'store_address_code' => env('POSTEX_STORE_ADDRESS_CODE'),
        'origin_city' => env('POSTEX_ORIGIN_CITY'),
    ],

];
