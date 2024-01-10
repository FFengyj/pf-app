<?php

namespace App\Controllers;

use App\Library\CommonHelper;
use Pf\System\Exceptions\Err\CustomErrException;
use Pf\System\Exceptions\JsonFmtException;

/**
 * Class IndexController
 * @package App\Controllers
 */
class IndexController extends ControllerBase
{
    /**
     * @throws JsonFmtException
     */
    public function indexAction(): void
    {
        try {
            $this->flash->successJson();
        } catch (CustomErrException $e) {
            throw new JsonFmtException($e->getMessage(), $e->getCode(), $e->getData(), $e);
        }
    }
}
