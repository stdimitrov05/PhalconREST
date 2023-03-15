<?php

namespace App\Exceptions\HttpExceptions;

use App\Exceptions\AbstractHttpException;

/**
 * Class Http404Exception
 *
 * Exception class for Not Found Error (404)
 *
 * @package App\Lib\Exceptions
 */
class Http404Exception extends AbstractHttpException
{
    protected ?int $httpCode = 404;
    protected ?string $httpMessage = 'Not Found';
}
