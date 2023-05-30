<?php

/**
 * 业务逻辑处理异常
 */

namespace App\Exceptions;

use App\Exceptions\Codes\Logic;
use Pf\System\Exceptions\Err\CustomErrException;

/**
 * Class LogicException
 * @package App\Exceptions
 * @author fyj
 */
class LogicException extends CustomErrException
{

    /**
     * @inheritDoc
     * @return array|mixed
     */
    protected function getErrCodeSettings()
    {
        return Logic::$MSGS;
    }
}
