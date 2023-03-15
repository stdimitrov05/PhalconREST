<?php

namespace App\Middleware;

use Phalcon\Events\Event;
use Phalcon\Mvc\Micro;
use Phalcon\Mvc\Micro\MiddlewareInterface;
use App\Exceptions\HttpExceptions\Http403Exception;

/**
 * FirewallMiddleware
 *
 * Checks the whitelist and allows clients or not
 */
class FirewallMiddleware implements MiddlewareInterface
{
    /**
     * Before anything happens
     * @param Event $event
     * @param Micro $application
     * @return bool
     */
    public function beforeHandleRoute(Event $event, Micro $application): bool
    {
        $whitelist = [
            '192.168.50.1',
            '84.54.189.83' // Office public
        ];

        $ipAddress = $application->request->getClientAddress();

        if (true !== in_array($ipAddress, $whitelist)) {
            throw new Http403Exception('Forbidden', 403);
        }

        return true;
    }

    /**
     * Calls the middleware
     * @param Micro $application
     * @return bool
     */
    public function call(Micro $application): bool
    {
        return true;
    }
}