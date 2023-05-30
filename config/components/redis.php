<?php

/**
 * redis 配置
 */

return [
    'default' => [
        //'host' => env('REDIS_HOST','192.168.3.150'),
        'host' => env('REDIS_HOST','127.0.0.1'),
        'port' => env('REDIS_PORT',6379),
        'auth' => env('REDIS_AUTH','19171455'),
        'db'   => env('REDIS_DB',4),
    ],
];
