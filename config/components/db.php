<?php

/**
 * 数据配置
 */

return [
    'default' => [
        'adapter'  => env('DB_DRIVER','mysql'),
        'options' => [
            PDO::ATTR_TIMEOUT => 5,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STRINGIFY_FETCHES => false
        ]
    ]
];