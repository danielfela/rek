<?php

use Phalcon\Cache\AdapterFactory;
use Phalcon\Cache\Cache;
use Phalcon\Config\Config;
use Phalcon\Di\FactoryDefault;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model\Manager;
use Phalcon\Mvc\View;
use Phalcon\Storage\SerializerFactory;

$di = new FactoryDefault();

/** @var $config Config */
$di->set("config", $config);

/**
 * Models manager
 */
$di->set('modelsManager', function () {
    return new Manager();
});

$di->set("dispatcher", function () {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace("Controllers");

    return $dispatcher;
});
/**
 * Sets the view component
 */
$di->setShared('view', function () {

    $config = $this->get('config');
    $view = new View();
    $view->setViewsDir($config->application->viewsDir);

    $view->registerEngines([
        ".volt" => \Phalcon\Mvc\View\Engine\Volt::class,
        ".phtml" => \Phalcon\Mvc\View\Engine\Php::class,
    ]);

    return $view;
});

/**
 * The URL component is used to generate all kind of urls in the application
 */
$di->setShared('url', function () {

    $config = $this->get('config');

    $url = new Phalcon\Mvc\Url();
    $url->setBaseUri($config->application->baseUri);

    return $url;
});

/**
 * Database connection is created based in the parameters defined in the configuration file
 */
$di->setShared('db', function () {

    $config = $this->get('config');
    $dbConfig = $config->database->toArray();
    $adapter = $dbConfig['adapter'];
    unset($dbConfig['adapter']);

    $dbConfig['options'] = [PDO::ATTR_CASE => PDO::CASE_NATURAL,];
    $class = 'Phalcon\Db\Adapter\Pdo\\' . $adapter;

    $connection = new $class($dbConfig);
    $connection->setNestedTransactionsWithSavepoints(true);

    return $connection;
});

$di->setShared('request', new  Phalcon\Http\Request());
$di->setShared('response', new  Phalcon\Http\Response());

$di->set('modelsCache', function () {

    $serializerFactory = new SerializerFactory();
    $adapterFactory = new AdapterFactory($serializerFactory);

    $options = [
        'defaultSerializer' => 'Php',
        'lifetime' => 7200
    ];

    $adapter = $adapterFactory->newInstance('apcu', $options);

    return new Cache($adapter);
});

