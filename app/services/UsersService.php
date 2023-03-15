<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Users;
use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;

/**
 * Business-logic for site frontend
 *
 * @UsersService
 * @\App\Services\UsersService
 * @uses \App\Services\AbstractService
 */
class UsersService extends AbstractService
{
    /**
     * @param array $data
     * @return null
     */
    public function create(array $data)
    {
        $user = new Users();
        $user->assign($data);
        $isCreated = $user->create();

        if ($isCreated !== true) {
            throw  new ServiceException(
                'Unable to create user',
                self::ERROR_UNABLE_TO_CREATE
            );
        }

       // Send email .....

        return null;
    }


}
