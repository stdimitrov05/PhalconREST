<?php

namespace App\Controllers;

use App\Exceptions\HttpExceptions\Http404Exception;
use App\Exceptions\HttpExceptions\Http422Exception;
use App\Exceptions\HttpExceptions\Http403Exception;
use App\Exceptions\HttpExceptions\Http500Exception;
use App\Exceptions\ServiceException;
use App\Services\AbstractService;
use App\Validation\LoginValidation;
use App\Validation\SignupValidation;

/**
 * @\App\Controllers\AuthController
 * @AuthController
 * @uses  \App\Controllers\AbstractController
 */
class AuthController extends AbstractController
{
    /**
    * Collects and validates the request parameters, creates a new user account,
    * and handles any errors that occur during the process.
    * @return void
    * @throws Http422Exception
    * @throws Http500Exception 
    */
    public function signup(): void
    {
        $data = [];

        // Collect and trim request params
        foreach ($this->request->getPost() as $key => $value) {
            $data[$key] = $this->request->getPost($key, ['string', 'trim']);
        }

        // Start validation
        $validation = new SignupValidation();
        $messages = $validation->validate($data);

        if (count($messages)) {
            $this->throwValidationErrors($messages);
        }

        try {
             $this->usersService->create($data);
        } catch (ServiceException $e) {
            throw match ($e->getCode()) {
                AbstractService::ERROR_UNABLE_TO_CREATE,
                => new Http422Exception($e->getMessage(), $e->getCode(), $e),
                default => new Http500Exception('Internal Server Error', $e->getCode(), $e),
            };
          }
    }

    /**
     * Collects and validates the request parameters, authenticates the user credentials,
     * and returns a response containing the authentication token and user information
     * @throws Http422Exception
     * @throws Http403Exception
     * @throws Http500Exception
     * @return array
     */
    public function login(): array
    {
        $data = [];
        // Collect and trim request params
        foreach ($this->request->getPost() as $key => $value) {
            $data[$key] = $this->request->getPost($key, ['string', 'trim']);
        }

        // Start validation
        $validation = new LoginValidation();
        $messages = $validation->validate($data);

        if (count($messages)) {
            $this->throwValidationErrors($messages);
        }

        try {
            $response = $this->authService->login($data);

        } catch (ServiceException $e) {
            throw match ($e->getCode()) {
                AbstractService::ERROR_UNABLE_TO_CREATE,
                AbstractService::ERROR_WRONG_EMAIL_OR_PASSWORD,
                => new Http422Exception($e->getMessage(), $e->getCode(), $e),
                AbstractService::ERROR_USER_NOT_ACTIVE,
                AbstractService::ERROR_ACCOUNT_DELETED,
                => new Http403Exception($e->getMessage(), $e->getCode(), $e),
                default => new Http500Exception('Internal Server Error', $e->getCode(), $e),
            };
          }

        return $response;
    }

    /**
     * Generates a new set of JWT access and refresh tokens for the authenticated user.
     * @throws Http404Exception
     * @throws Http422Exception
     * @throws Http500Exception
     * @retrun  array
     */
    public function refreshJWT(): array
    {
        try {
            $tokens = $this->authService->refreshJwtTokens();
        } catch (ServiceException $e) {
            throw match ($e->getCode()) {
                AbstractService::ERROR_NOT_FOUND,
                    => new Http404Exception($e->getMessage(), $e->getCode(), $e),
                AbstractService::ERROR_BAD_TOKEN
                    => new Http422Exception($e->getMessage(), $e->getCode(), $e),
                default => new Http500Exception('Internal Server Error', $e->getCode(), $e),
            };
        }

        return $tokens;
    }
}
