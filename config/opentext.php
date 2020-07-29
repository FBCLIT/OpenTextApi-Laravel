<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenText Default Client
    |--------------------------------------------------------------------------
    |
    | This option controls the default client (specified below) you would
    | like to be the default when attempting OpenText API operations.
    |
    */

    'default' => 'default',

    /*
     |--------------------------------------------------------------------------
     | OpenText Clients
     |--------------------------------------------------------------------------
     |
     | Next, you may define a client for each OpenText connection your
     | application requires. You must define a url, username and
     | password for each client you add into the configuration.
     |
     */

    'clients' => [
        'default' => [
            'url' => env('OPENTEXT_URL'),
            'username' => env('OPENTEXT_USERNAME'),
            'password' => env('OPENTEXT_PASSWORD'),
        ],
    ],
];
