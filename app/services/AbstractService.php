<?php

namespace App\Services;


use App\Lib\JWT;

/**
 * Class AbstractService
 *
 * @property \Phalcon\Db\Adapter\Pdo\Mysql $db
 * @property \Phalcon\Config\Config $config
 * @property \Redis $redis
 * @property RedisService $redisService
 * @property JWT $jwt
 *
 */
abstract class AbstractService extends \Phalcon\DI\Injectable
{
    /**
     * Invalid parameters anywhere
     */
    const ERROR_INVALID_PARAMETERS = 10010;

    /**
     * Record already exists
     */
    const ERROR_ALREADY_EXISTS = 10020;

    // Record  not found
    const  ERROR_NOT_FOUND = 10040;

    const  ERROR_UNABLE_TO_CREATE = 10050;
    const  ERROR_UNABLE_TO_DELETE = 10060;

    // Users errors
    const ERROR_USER_NOT_ACTIVE = 12010;
    const ERROR_WRONG_EMAIL_OR_PASSWORD = 12020;
    const ERROR_ACCOUNT_DELETED = 12030;

    // JWT errors
    const ERROR_BAD_TOKEN = 13020;

}
