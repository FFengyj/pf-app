<?php

/**
 * redis key常量定义
 */

namespace App\Constants;

/**
 * Class RedisKey
 * @package App\Constants
 * @author fyj
 */
class RedisKey
{
    const EXAMPLE_TEST_KEY = 'example_test_key';


    /**
     * 缓存设置
     */
    public static $SETTINGS = [

    ];

    /**
     * 获取过期时间
     *
     * @param $redis_key
     * @return int
     */
    public static function expire($redis_key = '')
    {
        $time = 7200; //default expire time is 2 hours
        if ($redis_key && isset(self::$SETTINGS[$redis_key]['expire_time'])) {
            $time = self::$SETTINGS[$redis_key]['expire_time'];
        }

        return $time;
    }
}
