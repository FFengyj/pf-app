<?php

namespace App\Tasks;


use App\Constants\Queue\QueueTube;

/**
 * Class QueueTask
 * @package Tasks
 */
class QueueTask extends QueueBase
{

    /**
     * 通用异步任务
     */
    public function apiMainTaskAction()
    {
        parent::run(QueueTube::API_MAIN_TASK);
    }



}
