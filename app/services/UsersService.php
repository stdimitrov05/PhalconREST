<?php

namespace App\Services;

use App\Exceptions\ServiceException;
use App\Models\Users;
use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;

/**
 * @UsersService
 * @\App\Services\UsersService
 * @uses \App\Services\AbstractService
 */
class UsersService extends AbstractService
{
    /**
     * Creates a new user account based on the provided data.
     * @param array $data
     * @throws ServiceException
     * @return void 
     * 
     */
    public function create(array $data): void
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

    }


}
