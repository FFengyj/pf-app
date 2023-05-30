<?php
/**
 * Dispatcher事件监听类
 */

namespace App\Listener;

use Pf\System\Core\Plugin\VerifyParams;
use Pf\System\Exceptions\Err\CustomErrException;
use Pf\System\Exceptions\JsonFmtException;
use Phalcon\Mvc\Dispatcher;

class AutoVerifyParams
{
    /**
     * @param $event
     * @param Dispatcher $dispatcher
     * @throws JsonFmtException
     */
    public function afterInitialize($event, Dispatcher $dispatcher)
    {
        $controller = $dispatcher->getControllerName();
        $action = $dispatcher->getActionName();

        $module_name = '';
        if (defined('MODULE_NAME')) {
            $module_name = ucfirst(strtolower(MODULE_NAME)) . '\\';
        }

        try {
            //参数验证
            $verify_class = 'App\Constants\Verify\\' . $module_name . ucfirst($controller);
            if (property_exists($verify_class, 'SETTINGS')) {
                $rules = ($verify_class::$SETTINGS)[$action] ?? [];
                if ($rules) {
                    $verify_obj = new VerifyParams($rules);
                    $verify_obj->verify($_REQUEST);
                }
            }
        } catch (CustomErrException $e) {
            throw new JsonFmtException($e->getMessage(), $e->getCode(), $e->getData(), $e);
        }

    }

}
