<?php

/**
 * 业务逻辑错误配置类，1300-1499
 */

namespace App\Exceptions\Codes;

use Phalcon\Logger;

/**
 * Class Runtime
 * @package Exceptions\Codes
 * @author fyj
 */
class Runtime
{
    const COUNTER_TYPE_NOT_EXISTS = 1300;
    const COUNTER_INIT_RESULT_NOT_NUMERIC = 1301;
    const COUNTER_REDIS_NUMBER_ERROR = 1302;
    const EMAIL_TYPE_INVALID  = 1303;
    const EMAIL_TPL_NOT_EXISTS  = 1304;


    /**
     * 返回给用户的错误信息，包含real_info、show_info、level 等字段
     *
     * real_info必填，表示错误的真实信息，比较敏感，一般不展示给用户
     * show_info可为空，用于展示给用户的信息。若不填则显示real_info中的信息
     * level  错误日志级别，默认为 Logger::WARNING, ERROR 及以上级别会记录log
     *
     * @var array
     */
    public static $MSGS = [

        self::COUNTER_TYPE_NOT_EXISTS => [
            'real_info' => '计数器类型: %s 不存在',
            'show_info' => '操作失败',
            'level' => Logger::ERROR,
        ],
        self::COUNTER_INIT_RESULT_NOT_NUMERIC => [
            'real_info' => '计数器[%s]初始化失败',
            'show_info' => '操作失败',
            'level' => Logger::ERROR,
        ],
        self::COUNTER_REDIS_NUMBER_ERROR => [
            'real_info' => '计数器数值小于0',
            'show_info' => '操作失败',
            'level' => Logger::ERROR,
        ],
        self::EMAIL_TYPE_INVALID => [
            'real_info' => '未配置的邮件类型',
            'level' => Logger::ERROR,
        ],
        self::EMAIL_TPL_NOT_EXISTS => [
            'real_info' => '邮件模板不存在',
            'level' => Logger::ERROR,
        ],
    ];
}

