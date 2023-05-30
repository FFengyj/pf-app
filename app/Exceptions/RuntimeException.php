<?php

/**
 * 业务逻辑处理异常
 */

namespace App\Exceptions;

use App\Exceptions\Codes\Runtime;
use Pf\System\Exceptions\Err\CustomErrException;

/**
 * Class RuntimeException
 * @package Exceptions
 * @author fyj
 */
class RuntimeException extends CustomErrException
{
    /**
     * @inheritDoc
     * @return array|mixed
     */
    protected function getErrCodeSettings()
    {
        return Runtime::$MSGS;
    }
}
