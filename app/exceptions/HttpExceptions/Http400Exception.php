<?php

namespace App\Exceptions\HttpExceptions;

use App\Exceptions\AbstractHttpException;

/**
 * Class Http400Exception
 *
 * Exception class for Bad Request Error (400)
 *
 * @package App\Lib\Exceptions
 */
class Http400Exception extends AbstractHttpException
{
    protected ?int $httpCode = 400;
    protected ?string $httpMessage = 'Bad request';
}
