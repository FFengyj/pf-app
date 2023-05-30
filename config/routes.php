<?php

/**
 * 默认路由配置
 */

use Phalcon\Mvc\Router;

$router = new Router();
$router->removeExtraSlashes(true);
$router->setDefaultNamespace('App\Controllers');

/**
 * 默认路由
 */
$router->add("/", 'Index::index');

/** @var Phalcon\Mvc\Router\Route $favicon */
//$favicon = $router->add('/favicon.ico');
//$favicon->beforeMatch(
//    function () {
//        ob_end_clean();
//        header('Content-type: image/jpeg');
//        echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');exit;
//    }
//);

$router->add("/:controller/:action/:params", [
    "controller" => 1,
    "action"     => 2,
    "params"     => 3
]);


return $router;





