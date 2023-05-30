<?php

namespace App\Controllers\Api\V1;

use App\Controllers\Api\ApiController;
use Pf\System\Exceptions\Err\CustomErrException;
use Pf\System\Exceptions\JsonFmtException;

/**
 * Class ExampleController
 * @package App\Controllers\Api\V1
 */
class ExampleController extends ApiController
{
    /**
     * @throws JsonFmtException
     */
    public function testAction(): void
    {
        try {
            $result = [1];

            $this->flash->successJson($result);
        } catch (CustomErrException $e) {
            throw new JsonFmtException($e->getMessage(), $e->getCode(), $e->getData(), $e);
        }
    }


}
