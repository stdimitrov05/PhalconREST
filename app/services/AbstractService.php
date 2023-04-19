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
    const ERROR_INVALID_PARAMETERS = 10010;

    const ERROR_NOT_FOUND = 10040;
    const ERROR_UNABLE_TO_CREATE = 10050;
    const ERROR_UNABLE_TO_DELETE = 10060;

    const ERROR_USER_NOT_ACTIVE = 11010;
    const ERROR_WRONG_EMAIL_OR_PASSWORD = 11020;
    const ERROR_ACCOUNT_DELETED = 11030;

    const ERROR_BAD_TOKEN = 12010;

}
