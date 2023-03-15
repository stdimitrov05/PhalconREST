<?php

namespace App\Middleware;

use Exception;
use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * RequestMiddleware
 *
 * Assign application/json raw data to $_POST
 */
class RequestMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Event $event
     * @param Micro $application
     * @throws Exception
     *
     * @returns bool
     */
    public function beforeHandleRoute(Event $event, Micro $application)
    {
        $contentType = $application->request->getHeader('CONTENT_TYPE');

        switch ($contentType) {
            case 'application/json':
            case 'application/json;charset=utf-8':
            case 'application/json;charset=UTF-8':
                $jsonRawBody = $application->request->getJsonRawBody(true);
                if ($application->request->getRawBody() && !$jsonRawBody) {
                    throw new Exception("Invalid JSON syntax");
                }
                $_POST = $jsonRawBody;
                break;
        }
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
