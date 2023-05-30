<?php
/**
 * Dispatcher事件监听类
 */

namespace App\Listener;

use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

class CorsMiddleware
{
    /**
     * @param Event $event
     * @param Dispatcher $dispatcher
     */
    public function beforeDispatchLoop($event, Dispatcher $dispatcher)
    {
        /* CORS headers */
        header("Access-Control-Allow-Credentials: true");
        header("Access-Control-Allow-Origin: " . (isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : "*"));
        header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Accept, Origin, Authorization, Token");
        header("Access-Control-Allow-Methods: GET, POST, DELETE, PUT, OPTIONS");

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header("HTTP/1.1 204 No Content");
            exit;
        }
    }
}
