<?php

/**
 * 自定义配置
 */
return [
    'routes'            => [
        'default' => ROOT_PATH . '/config/routes.php',
        'api'     => ROOT_PATH . '/config/routes/api.routes.php',
    ],

    'components_config' => [
        'path'    => ROOT_PATH . "/config/components",
        'adapter' => 'php',
    ],

    'logic'       => [
        'jwt_key' => env('ADMIN_JWT_TOKEN_KEY', 'NZyCIBEnG4rvL9hL'),
    ],
];
