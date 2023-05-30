<?php

/**
 * redis key常量定义
 */

namespace App\Constants;

/**
 * Class RedisKey
 * @package Constants
 * @author fyj
 */
class RedisKey
{
    public const HSET_ONLINE_USERS = 'hset_online_users';
    public const LIST_QUEUE_TASK_KEY = 'list_queue_task_key';
    public const HSET_RECORD_VIDEO_USERS = 'hset_record_video_users';
    public const NOTICE_PIC_CACHE_KEY    = 'notice_pic_cache_key|type:%d';
    public const SETBIT_CM_GOODS_TYPE_MAP   = 'setbit_cm_goods_type_map|t:%d';

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
