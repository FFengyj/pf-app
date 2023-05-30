<?php

/**
 * 业务逻辑错误配置类，2000-2999
 */

namespace App\Exceptions\Codes;

use Phalcon\Logger;

/**
 * Class Logic
 * @package App\Exceptions\Codes
 * @author fyj
 */
class Logic
{
    // 全局配置(2000-2019)
    public const CUSTOM_ERROR_MSG = 2000;


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
        self::CUSTOM_ERROR_MSG => [
            'real_info' => '%s',
        ]

    ];

}

