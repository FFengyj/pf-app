<?php


return [
    'logger.queue' =>  [
        'class' => App\Logger\LoggerRow::class,
        'params' => [
            'filename' => "queue_failed.log",
            'path'  => env('DEFAULT_LOGGER_PATH',ROOT_PATH .'/runtime/logs'),
            'level' => env('DEFAULT_LOGGER_LEVEL',7), // default \Phalcon\Logger::DEBUG
        ]
    ]
];
