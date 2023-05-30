<?php

namespace App\Logger;


use Phalcon\Logger\Adapter\File;
use Phalcon\Logger\Formatter\Line;

/**
 * Class Custom
 * @package Logger
 * @author fyj
 */
class LoggerRow extends File
{

    /**
     * Custom constructor.
     * @param $params
     */
    public function __construct($params)
    {
        if (!is_dir($params['path'])) {
            mkdir($params['path'], 0777, true);
        }
        parent::__construct(rtrim($params['path'],"/") . "/" . $params['filename']);

        $format = new Line("%message%","Y-m-d H:i:s");
        $this->setFormatter($format);

        if (isset($params['level'])) {
            $this->setLogLevel($params['level']);
        }

    }

}
