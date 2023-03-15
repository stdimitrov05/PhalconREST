<?php

namespace App\Middleware;

use Exception;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;

/**
 * ResponseMiddleware
 *
 * Manipulates the response
 */
class ResponseMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     *
     * @param Micro $app
     * @return bool
     * @throws Exception
     */
    public function call(Micro $app): bool
    {
        $return = $app->getReturnedValue();

        if (is_array($return) || is_null($return)) {
            $app->response->setJsonContent($return);

        } elseif (strlen($return) == 0) {
            // Successful response without any content
            $app->response->setStatusCode('204', 'No Content');

        } else {
            // Unexpected response
            throw new Exception('Bad Response');
        }

        // Sending response to the client
        $app->response->send();

        return true;
    }
}
