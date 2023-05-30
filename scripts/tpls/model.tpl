<?php

namespace Models;

use Pf\System\Core\Mvc\ModelBase;

/**
 * Class {{entityName}}
 * @package Models
 */
class {{entityName}} extends ModelBase
{
{{entityProperty}}
{{beforeCreate}}

    /**
     * @return string
     */
    public function getSource()
    {
        return '{{entityTable}}';
    }
}