<?php

/**
 * 命令行入口程序
 */

use Pf\System\Bootstrap;
use Phalcon\DI\FactoryDefault\CLI as CliDI;
use Phalcon\CLI\Console as ConsoleApp;

define('ROOT_PATH', dirname(__DIR__));

require ROOT_PATH . '/vendor/autoload.php';


$bootstrap = new Bootstrap(new CliDI());
$bootstrap(ConsoleApp::class,function(ConsoleApp $app,$di){
    $params = get_task_params('Tasks');
    $app->handle($params);
});





