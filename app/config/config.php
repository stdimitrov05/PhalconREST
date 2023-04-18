<?php

return new \Phalcon\Config\Config(
    [
         'db' => [
            'adapter' => getenv('DB_ADAPTER'),
            'host' => getenv('DB_HOST'),
            'username' => getenv('DB_USERNAME'),
            'password' => getenv('DB_PASSWORD'),
            'dbname' => getenv('DB_NAME'),
            'charset' => getenv('DB_CHARSET'),
            'collation' => getenv('DB_COLLATION')
        ],
        'application' => [
            'controllersDir' => "app/controllers/",
            'modelsDir' => "app/models/",
            'emailsDir' => APP_PATH . '/views/emails/',
            'logsDir' => BASE_PATH . '/tmp/logs/',
            'baseUri' => "/",
            'domain' => getenv('DOMAIN'),
            'publicUrl' => "https://" . getenv("DOMAIN"),
        ],
        'redis' => [
            'redisHost' => getenv('REDIS_HOST'),
            'redisPort' => getenv('REDIS_PORT'),
            'usersPrefix' => getenv('REDIS_USERS_PREFIX'),
            'jtiPostfix' => getenv('REDIS_JTI_POSTFIX'),
            'whiteListPrefix' => getenv('REDIS_WHITE_LIST_PREFIX')
        ],
        'mail' => [
            'noreplyEmail' => getenv('NOREPLY_EMAIL'),
            'noreplyName' => getenv('NOREPLY_NAME'),
            'emailHost' => getenv('EMAIL_HOST'),
            'emailPort' => getenv('EMAIL_PORT'),
            'emailSmtpSecure' => getenv('SMTPSECURE'),
        ],
        'auth' => [
            'key' => getenv('JWT_KEY'),
            'accessTokenExpire' => getenv('JWT_ACCESS_TOKEN_EXPIRE'),
            'refreshTokenExpire' => getenv('JWT_REFRESH_TOKEN_EXPIRE'),
            'refreshTokenRememberExpire' => getenv('JWT_REFRESH_TOKEN_REMEMBER_EXPIRE'),
            'ignoreUri' => [
                '/',
                '/signup:POST',
                '/login:POST',
            ]
        ],
    ]
);
