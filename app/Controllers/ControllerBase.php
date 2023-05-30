<?php

namespace App\Controllers;

use Phalcon\Mvc\Controller;

/**
 * Class ControllerBase
 * @package App\Controllers
 * @author fyj
 */
class ControllerBase extends Controller
{
    /**
     * @param null $name
     * @param null $filters
     * @param string $default
     * @return mixed
     */
    protected function getParams($name = null, $filters = null, $default = '')
    {
        if ($name !== null) {
            return $this->request->get($name, $filters, $default);
        }
        return array_diff_key($this->request->get(), ['_args' => null, '_url' => null]);
    }
}
