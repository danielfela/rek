<?php
/**
 * Starting the application
 * Assign service locator to the application
 *
 * On finish or error session is stored
 *
 * @var $di
 */
$app = new \Phalcon\Mvc\Micro($di);

use Controllers\IndexController as IndexController;
use Phalcon\Mvc\Micro\Collection as MicroCollection;

$mc = new MicroCollection();
$mc->setHandler(IndexController::class, true);
$mc->setLazy(true);
$mc->get('/', 'index');
$mc->get('/index', 'index');
$mc->get('/index/get', 'get');
$mc->post('/index/update/{id}', 'update');
$mc->post('/index/delete/{id}', 'delete');
$app->mount($mc);

$app->notFound(function () use ($app) {
    $message = 'Pusta strona? jak to...';
    $app->response->setStatusCode(404, 'Not Found')->sendHeaders()->setContent($message)->send();
});

$app->handle($_SERVER["REQUEST_URI"]);
