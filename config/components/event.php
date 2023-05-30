<?php

/**
 * 事件配置
 */

return [

    'dispatcher:mvc' => [
        'api' => [
            [
                'attach'   => 'dispatch',
                'listener' => App\Listener\ApiDispatcher::class,
                'priority' => 0,
            ],
            [
                'attach'   => 'dispatch:beforeDispatchLoop',
                'listener' => App\Listener\CorsMiddleware::class,
                'priority' => 200,
            ],
            [
                'attach'   => 'dispatch:afterInitialize',
                'listener' => App\Listener\AutoVerifyParams::class,
                'priority' => 0,
            ],
        ],
    ]

];

