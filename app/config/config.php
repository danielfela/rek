<?php

$config = new \Phalcon\Config\Config([
    'application' => [
        'title' => 'REKRUTACJA',
        'description' => 'REKRUTACJA',
        'controllersDir' => APP_PATH . '/controllers/',
        'libraryDir' => APP_PATH . '/library/',
        'modelsDir' => APP_PATH . '/models/',
        'viewsDir' => APP_PATH . '/views/',
        'baseUri' => '/',
    ],
    'database' => [
        'host' => 'localhost',
        'dbname' => 'danielfela_rek',
        'password' => 'C88AEDZqmDPO1wEOekS9',
        'username' => 'danielfela_rek',
        'adapter' => 'mysql',
        'port' => 3306,
    ],
]);

return $config;
