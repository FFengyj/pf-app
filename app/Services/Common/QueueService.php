<?php
/**
 * 队列服务类
 */

namespace App\Services\Common;



use App\Constants\Queue\QueueConfig;
use App\Exceptions\Codes\Runtime;
use App\Exceptions\RuntimeException;
use Pheanstalk\PheanstalkInterface;

class QueueService extends ServiceBase
{

    /**
     * 放入队列，异步同步数据
     *
     * @param $task_type
     * @param $data
     * @param int $delay
     * @param int $priority
     * @return bool
     */
    public static function sendToQueue($task_type, $data, $delay = 0, $priority = PheanstalkInterface::DEFAULT_PRIORITY)
    {
        $queue_data = ['task_type' => $task_type, 'data' => $data, 'add_time'  => \time()];

        try {
            $job_id = Di('queue')
                ->useTube(QueueConfig::$SETTINGS[$task_type]['tube'])
                ->put(json_encode($queue_data), $priority, $delay);

            if (!$job_id) {
                throw new RuntimeException(Runtime::COUNTER_INIT_RESULT_NOT_NUMERIC);
            }

            return $job_id;
        } catch (\Exception $e) {
            self::saveFailedTask($queue_data);

            return false;
        }
    }

    /**
     * 记录执行失败的任务
     *
     * @param $task_data
     */
    public static function saveFailedTask($task_data)
    {
        $record_data = [
            'task_type'     => $task_data['task_type'],
            'data'          => $task_data['data'],
            'exec_date'     => $task_data['add_time'],
        ];

        Di('logger.queue')->error(json_encode($record_data));
    }

}
