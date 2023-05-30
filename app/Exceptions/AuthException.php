<?php

/**
 * 业务逻辑处理异常
 */

namespace App\Exceptions;

use App\Exceptions\Codes\Logic;
use Pf\System\Exceptions\Err\CustomErrException;

/**
 * Class AuthException
 * @package App\Exceptions
 * @author fyj
 */
class AuthException extends CustomErrException
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
