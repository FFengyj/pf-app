<?php
namespace App\Tasks;

use App\Constants\Queue\QueueConfig;
use App\Services\Common\QueueService;

/**
 * 队列任务消费者
 */


class QueueBase extends \Phalcon\CLI\Task
{

    protected $exit = false;
    protected $max_memory;


    protected function init()
    {
        ini_set('default_socket_timeout', 86400);
        pcntl_signal(SIGUSR1, function($signal) {  // supervisor stopsignal=USR1
            $this->exit = $signal == SIGUSR1;
        });

        //最大使用分配内存的50%
        $this->max_memory = (int)ini_get('memory_limit') * 0.5;

    }

    /**
     * 执行队列
     *
     * @param $tube
     * @param $timeout
     */
    public function run($tube,$timeout = 3600)
    {

        $this->init();
        $queue = Di('queue');
        $queue->watch($tube);

        while (1) {

            $job = $queue->reserve($timeout);
            if (!$job) {
                continue;
            }

            $body = json_decode($job->getData(),true);

            try{

                $taskType= $body['task_type'];
                if (!isset(QueueConfig::$SETTINGS[$taskType]['exec_func'])) {
                    throw new \Exception("task type: " .$taskType . " missing exec_func",-1);
                }

                list($class,$method) = explode("::",QueueConfig::$SETTINGS[$taskType]['exec_func']);

                $ret = call([$class,$method],[$body['data']]);
                if (!$ret) {
                    QueueService::saveFailedTask($body);
                }
                $queue->delete($job);

            } catch (\Exception $e) {

                QueueService::saveFailedTask($body);
                $queue->delete($job);
                Di('logger')->error('queue_error', ['error' => $e]);

            } finally {

                pcntl_signal_dispatch();
                if ($this->exit) {
                    exit();
                }
                $use_memory = round(memory_get_usage(true) / 1048576, 2);
                if ($use_memory >= $this->max_memory) {
                    Di('logger')->error('queue_error', ['msg' => "already use memory {$use_memory}M"]);
                    exit();
                }
            }
        }
    }


}
