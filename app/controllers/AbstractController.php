<?php

namespace App\Controllers;

use App\Exceptions\HttpExceptions\Http400Exception;

/**
 * Class AbstractController
 *
 * @property \Phalcon\Http\Request                  $request
 * @property \Phalcon\Http\Response                 $htmlResponse
 * @property \Phalcon\Db\Adapter\Pdo\Mysql          $db
 * @property \Phalcon\Config                         $config
 * @property \App\Services\FrontendService          $frontendService
 * @property \App\Services\AuthService              $authService
 * @property \App\Services\UsersService             $usersService
 */
abstract class AbstractController extends \Phalcon\DI\Injectable
{
    /**
     * Route not found. HTTP 404 Error
     */
    const ERROR_NOT_FOUND = 1;

    /**
     * Invalid Request. HTTP 400 Error.
     */
    const ERROR_INVALID_REQUEST = 2;

    /**
     * Format and throw exception on validation errors
     */
    public function throwValidationErrors($messages)
    {
        $errors = [];

        foreach ($messages as $message) {
            $errors[$message->getField()] = $message->getMessage();
        }

        $exception = new Http400Exception(
            'Input parameters validation error',
            self::ERROR_INVALID_REQUEST
        );

        throw $exception->addErrorDetails($errors);
    }

}
