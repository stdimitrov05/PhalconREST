<?php

namespace App\Exceptions;

/**
 * Class ServiceException
 *
 * Runtime exception which is generated on the service level.
 * It signals about an error in business logic.
 *
 * @package App\Exceptions
 */
class ServiceException extends \RuntimeException
{
    protected $code;
}
