<?php

namespace App\Exceptions\HttpExceptions;

use App\Exceptions\AbstractHttpException;

/**
 * Class Http422Exception
 *
 * Exception class for Unprocessable entity Error (422)
 *
 * @package App\Lib\Exceptions
 */
class Http422Exception extends AbstractHttpException
{
    protected ?int $httpCode = 422;
    protected ?string $httpMessage = 'Unprocessable entity';
}
