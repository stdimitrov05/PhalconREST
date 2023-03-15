<?php

namespace App\Exceptions\HttpExceptions;

use App\Exceptions\AbstractHttpException;

/**
 * Class Http401Exception
 *
 * Exception class for Unauthorized Error (401)
 *
 * @package App\Lib\Exceptions
 */
class Http401Exception extends AbstractHttpException
{
    protected ?int $httpCode = 401;
    protected ?string $httpMessage = 'Unauthorized';
}
