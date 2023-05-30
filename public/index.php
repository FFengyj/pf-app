<?php

use Pf\System\Bootstrap;
use Phalcon\Di\FactoryDefault as MvcDi;
use Phalcon\Mvc\Application as MvcApp;

$modules = ['api'];
$model_name = explode('/', parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[1] ?? '';

define('MODULE_NAME', in_array(strtolower($model_name),$modules) ? $model_name : '');
define('ROOT_PATH', dirname(__DIR__));


require ROOT_PATH . '/vendor/autoload.php';

$options = [
    'root_path'   => ROOT_PATH,
    'module_name' => MODULE_NAME,
];

$bootstrap = new Bootstrap(new MvcDi(), $options);
$bootstrap(MvcApp::class, function (MvcApp $app, MvcDi $di) {
    echo $app->handle()->getContent();
});


