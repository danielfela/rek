<?php

ini_set('display_errors', 'On');
ini_set('xdebug.var_display_max_depth', '5');
date_default_timezone_set('UTC');

define('APP_PATH', realpath('..') . '/app');

error_reporting(E_ALL);
$debug = new \Phalcon\Support\Debug();
$debug->listen();

/** @var \Phalcon\Di\FactoryDefault $di */
try {

    /**
     * Read the configuration
     */
    $config = include APP_PATH . '/config/config.php';

    /**
     * Include Autoloader.
     */
    include APP_PATH . '/config/loader.php';

    /**
     * Include Services.
     */
    include APP_PATH . '/config/services.php';

    /**
     * Include Application.
     */
    include APP_PATH . '/config/app.php';
    /**
     * Handle the request
     */
} catch (\Exception $e) {

    var_dump($e);
    print_r($e->getMessage() . '<br>');
    print_r('<pre>' . $e->getTraceAsString() . '</pre>');

    return (new Phalcon\Http\Response)->setStatusCode(500, 'Error')->sendHeaders()->send();
}
