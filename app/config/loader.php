<?php

$loader = new Phalcon\Autoload\Loader();
$loader->setNamespaces(
  [
    'App\Services'    => realpath(__DIR__ . '/../services/'),
    'App\Controllers' => realpath(__DIR__ . '/../controllers/'),
    'App\Models'      => realpath(__DIR__ . '/../models/'),
    'App\Middleware'  => realpath(__DIR__ . '/../middleware'),
    'App\Exceptions'  => realpath(__DIR__ . '/../exceptions'),
    'App\Validation'  => realpath(__DIR__ . '/../validation'),
    'App\Lib'         => realpath(__DIR__ . '/../lib')
  ]
);

$loader->register();

/**
* Composer autoload
*/
require_once BASE_PATH . '/vendor/autoload.php';
