<?php
$loader = new \Phalcon\Autoload\Loader();

/** @var ArrayObject $config */

$loader->setNamespaces([
    'Controllers' => [$config->application->controllersDir],
    'Library' => [$config->application->libraryDir],
    'Model' => [$config->application->modelsDir],
]);

$loader->register();



