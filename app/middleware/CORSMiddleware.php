<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * CORSMiddleware
 *
 * CORS checking
 */
class CORSMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     * @param Event $event
     * @param Micro $application
     * @return true|void
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        if ($application->request->getHeader('ORIGIN')) {
            $origin = $application->request->getHeader('ORIGIN');
        } else {
            $origin = '*';
        }

        $allowedMethods = 'GET,PUT,POST,DELETE,OPTIONS';
        $allowedHeaders = 'Origin, X-Requested-With, Content-Range, Content-Disposition, Content-Type, ';
        $allowedHeaders .= 'Authorization, Content-Length, Cache-Control, Pragma';

        if (strtoupper($application->request->getMethod()) == 'OPTIONS') {
            $application->response
                ->setHeader('Access-Control-Allow-Origin', $origin)
                ->setHeader('Access-Control-Allow-Methods', $allowedMethods)
                ->setHeader('Access-Control-Allow-Headers', $allowedHeaders)
                ->setHeader('Access-Control-Allow-Credentials', 'true');

            $application->response->setStatusCode(200, 'OK')->send();

            exit;
        }

        $application->response
            ->setHeader('Access-Control-Allow-Origin', $origin)
            ->setHeader('Access-Control-Allow-Methods', $allowedMethods)
            ->setHeader('Access-Control-Allow-Headers', $allowedHeaders)
            ->setHeader('Access-Control-Allow-Credentials', 'true');

        return true;
    }

    /**
     * Calls the middleware
     * @param Micro $application
     * @return true
     */
    public function call(Micro $application): bool
    {
        return true;
    }
}