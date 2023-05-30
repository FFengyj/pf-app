<?php
/**
 * 队列配置
 */

namespace App\Constants\Queue;


class QueueConfig
{

    //示例队列测试
    const EXAMPLE_QUEUE_TEST                              = 100;




    public static $SETTINGS = [

        self::EXAMPLE_QUEUE_TEST => [
            'tube'      => QueueTube::API_MAIN_TASK,
            'exec_func' => 'App\Services\ExampleService::save',
        ],

    ];
}
