<?php

/**
 * beanstalk 配置
 */

return [
    'host' => env('BEANSTALK_HOST','127.0.0.1'),
    'port' => env('BEANSTALK_PORT',11311),
    'connect_timeout' => env('BEANSTALK_CONNECT_TIMEOUT',5),
    'connect_persistent' => env('BEANSTALK_CONNECT_PERSISTENT',false),
];