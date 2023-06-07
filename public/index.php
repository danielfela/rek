<?php

ini_set('display_errors', 'On');
error_reporting(E_ALL);

$urlArray = explode('/',$_GET['_url']);

$action = count($urlArray) > 1 ? $urlArray[1] : null;
if(empty($action)) {
    $action = 'index';
}

include_once '../config/config.php';
global $dbConfig;
$dbh = new PDO(
    'mysql:host='.$dbConfig->host.';dbname='.$dbConfig->dbname,
    $dbConfig->user,
    $dbConfig->pass,
    [
        PDO::ATTR_CASE  => PDO::CASE_NATURAL,
    ]
);

include_once '../app/Controllers/Controller.php';
$controller = new \Controllers\Controller();

include_once '../app/Models/Model.php';
$model = new \Models\Model();

if(method_exists($controller, $action)) {
    $controller->model = $model;
    $controller->$action();
}
else{
    throw new Exception('Action unknown');
}


die();
