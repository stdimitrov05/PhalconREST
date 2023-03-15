<?php

use App\Exceptions\AbstractHttpException;
use App\Middleware\RequestMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\CORSMiddleware;
use App\Middleware\ResponseMiddleware;

define('BASE_PATH', dirname(__DIR__));
const APP_PATH = BASE_PATH . '/app';

try {
    define('API_VERSION', getenv('API_VERSION'));

    // Autoload classes
    require APP_PATH . '/config/loader.php';


    // Loading config
    $config = require(APP_PATH . '/config/config.php');


    // Initializing DI container
    $di = require APP_PATH . '/config/di.php';


    // Create a new Events Manager
    $eventsManager = new \Phalcon\Events\Manager();


    // Initializing application
    $app = new \Phalcon\Mvc\Micro($di);

    // Setting up routing
    require APP_PATH . '/config/routes.php';


    // Executed before every route is executed
    // Return false cancels the route execution
    // $eventsManager->attach('micro', new FirewallMiddleware());
    $eventsManager->attach('micro', new CORSMiddleware());
    $eventsManager->attach('micro', new RequestMiddleware());
    $eventsManager->attach('micro', new AuthMiddleware());

    $app->before(new CORSMiddleware());
    $app->before(new RequestMiddleware());
    $app->before(new AuthMiddleware());

    // Making the correct answer after executing
    $app->after(new ResponseMiddleware());

    $app->setEventsManager($eventsManager);

    // Processing request
    $app->handle($_SERVER["REQUEST_URI"]);

} catch (AbstractHttpException $e) {
    $response = $app->response;
    $response->setStatusCode($e->getCode(), $e->getMessage());
    $response->setJsonContent($e->getAppError());
    $response->send();

} catch (\Phalcon\Http\Request\Exception $e) {
    $app->response->setStatusCode(400, 'Bad request')
          ->setJsonContent([
              AbstractHttpException::KEY_CODE    => 400,
              AbstractHttpException::KEY_MESSAGE => 'Bad request'
          ])
        ->send();

} catch (\Exception $e) {
    $di->getLogger()->error($e->getMessage());

    // Standard error format
    $result = [
        AbstractHttpException::KEY_CODE    => 500,
        AbstractHttpException::KEY_MESSAGE => 'Some error occurred on the server.'
    ];

    // Sending error response
    $app->response->setStatusCode(500, 'Internal Server Error')
        ->setJsonContent($result)
        ->send();
}
