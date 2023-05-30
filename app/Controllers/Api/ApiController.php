<?php

namespace App\Controllers\Api;

use App\Controllers\ControllerBase;
use App\Exceptions\Codes\Logic;
use App\Exceptions\LogicException;
use App\Library\CommonHelper;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;

/**
 * Class SysController
 * @package Controllers\Sys
 * @author fyj
 */
class ApiController extends ControllerBase
{
    /**
     * 执行路由之前需要处理的事情
     *
     * @param Dispatcher $dispatcher
     * @throws DispatchException
     */
    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        $params = [];
        $content_type = trim($this->request->getContentType());
        if (substr_compare($content_type, 'application/json', 0, 16, true) == 0) {
            $row_body = $this->request->getRawBody();
            if (strtolower($this->request->getHeader('Content-Encoding')) == 'gzip') {
                $row_body = gzdecode($row_body);
            }
            $params = json_decode($row_body, true) ?? [];
        } else if (substr_compare($content_type, 'application/x-www-form-urlencoded', 0, 33, true) == 0) {
            parse_str($this->request->getRawBody(), $params);
        }

        $_REQUEST['_args'] = $dispatcher->getParams();
        $_REQUEST = array_merge($params, $_REQUEST);
    }

    /**
     * 初始化函数
     */
    public function initialize()
    {

    }


    /**
     * @return bool
     * @throws LogicException
     */
    public function checkIpAccess()
    {
        if (env('APP_ENV') == 'prd' && !CommonHelper::isInternalIp(client_ip())) {
            throw new LogicException(Logic::CLI_API_IP_DENY);
        }
        return true;
    }
}
