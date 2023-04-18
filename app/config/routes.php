<?php

/*============================
Frontend
=============================*/

$frontendCollection = new \Phalcon\Mvc\Micro\Collection();
$frontendCollection->setPrefix(API_VERSION)
  ->setHandler('\App\Controllers\FrontendController', true)
  ->get('/', 'indexAction');
$app->mount($frontendCollection);

/*============================
Authentication
=============================*/

$authCollection = new \Phalcon\Mvc\Micro\Collection();
$authCollection->setPrefix(API_VERSION)
  ->setHandler('\App\Controllers\AuthController', true)
  ->post('/signup', 'signup')
  ->post('/login', 'login')
  ->get('/refresh/tokens', 'refreshJWT');

$app->mount($authCollection);

// Not found URLs
$app->notFound(
  // Full information for dev stage 
  // new \Exception('URI not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
    function () use ($app) {
        throw new \App\Exceptions\HttpExceptions\Http404Exception(
            'URI not found or error in request.',
            \App\Controllers\AbstractController::ERROR_NOT_FOUND,
            new \Exception('URI not found: ' . $app->request->getMethod() . ' ' . $app->request->getURI())
        );
    }
);
