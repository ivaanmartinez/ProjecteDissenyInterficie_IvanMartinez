<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Broadcast Driver
    |--------------------------------------------------------------------------
    |
    | This option controls the default broadcast driver that will be used
    | by your application. The "pusher" driver is a great choice for
    | applications, but you may also use other drivers like "redis".
    |
    */
    'default' => env('BROADCAST_DRIVER', 'pusher'),

    /*
    |--------------------------------------------------------------------------
    | Broadcast Connections
    |--------------------------------------------------------------------------
    |
    | All of the available broadcast drivers for your application are listed
    | here. You can add more connections to this array if needed, and then
    | reference them when broadcasting events.
    |
    */
    'connections' => [

        'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'useTLS' => true,
            ],
        ],
    ],
];
