<?php
/**
 * Dispatcher事件监听类
 */

namespace App\Listener;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class ApiDispatcher
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     * @param $e
     */
    public function beforeException(Event $event, Dispatcher $dispatcher, $e)
    {
        // 处理404异常
        if ($e instanceof DispatchException) {
            $show_msg = '404 NOT FOUND';
            Di('flash')->errorJson(-1, $show_msg);
            exit;
        }
    }
}
