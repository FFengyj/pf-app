<?php

/**
 * api路由配置
 */

use Phalcon\Mvc\Router;
use Phalcon\Mvc\Router\Group;

$router = new Router();
$router->removeExtraSlashes(true);


$v1 = new Group(['namespace' => 'App\Controllers\Api\V1']);
$v1->setPrefix('/api/v1');

$v1->addGet('/example/test', 'Example::test'); //Example


$router->mount($v1);

return $router;




