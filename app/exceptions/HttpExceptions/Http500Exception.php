<?php

namespace App\Exceptions\HttpExceptions;

use App\Exceptions\AbstractHttpException;

/**
 * Class Http500Exception
 *
 * Exception class for Internal Server Error (500)
 *
 * @package App\Lib\Exceptions
 */
class Http500Exception extends AbstractHttpException
{
    protected ?int $httpCode = 500;
    protected ?string $httpMessage = 'Internal Server Error';
}
