<?php

namespace App\Lib;


use App\Exceptions\ServiceException;
use App\Services\AbstractService;
use Phalcon\Encryption\Security\JWT\Builder;
use Phalcon\Encryption\Security\JWT\Exceptions\ValidatorException;
use Phalcon\Encryption\Security\JWT\Signer\Hmac;
use Phalcon\Encryption\Security\JWT\Token\Parser;
use Phalcon\Encryption\Security\JWT\Token\Token;
use Phalcon\Encryption\Security\JWT\Validator;

class JWT extends AbstractService
{
    const ALGO = 'sha512';

    /**
     * generateTokens
     * Generate access and refresh jwt tokens
     * @param int $userId
     * @param int $remember
     * @return array
     * @throws ValidatorException
     * @throws \RedisException
     * @retrun  array
     */
    public function generateTokens(int $userId, int $remember = 0): array
    {
        // Generate jti
        $jti = base64_encode(openssl_random_pseudo_bytes(32));
        $signer = new Hmac(self::ALGO);
        $iat = time();
        $iss = $this->config->application->domain;
        $exp = $iat + $this->config->auth->accessTokenExpire;

        // Create accessToken with expire 2 minutes
        $accessToken = (new Builder($signer))
            ->setExpirationTime($exp)
            ->setPassphrase($this->config->auth->key)
            ->setNotBefore($iat)
            ->setSubject($userId)
            ->setIssuer($iss)
            ->setIssuedAt($iat)
            // Get token object
            ->getToken()
            // Get token string
            ->getToken();

        // Longer expiration time if user click remember me
        $refreshExpire = $remember == 1
            ? $this->config->auth->refreshTokenRememberExpire
            : $this->config->auth->refreshTokenExpire;

        // Create refreshToken
        $refreshToken = (new Builder($signer))
            ->setExpirationTime($iat + $refreshExpire)
            ->setPassphrase($this->config->auth->key)
            ->setNotBefore($iat)
            ->setId($jti)
            ->setIssuer($iss)
            ->setIssuedAt($iat)
            ->setSubject($userId)
            // Get token object
            ->getToken()
            // Get token string
            ->getToken();

        // If accessToken or refreshToken has not created
        if (!$accessToken || !$refreshToken) {
            throw  new ServiceException(
                'Unable to create JWT tokens',
                self::ERROR_UNABLE_TO_CREATE
            );
        }

        // Store JWT refresh token jti in redis
        $this->redisService->storeJti($userId, $jti, $refreshExpire);

        return [
            "accessToken" => $accessToken,
            "refreshToken" => $refreshToken,
            'expireAt' => $iat + $refreshExpire,
        ];
    }

    /**
     * Decode JWT tokens
     * @params string $token
     * @return \Phalcon\Encryption\Security\JWT\Token\Token
     */
    public function decode(string $token): object
    {
        try {
            $parser = new Parser();
            return $parser->parse($token);

        } catch (\InvalidArgumentException $exception) {
            throw new ServiceException(
                'Bad token',
                self::ERROR_BAD_TOKEN
            );
        }
    }

    /**
     * Validate JWT tokens
     * @param Token $token
     * @throws ValidatorException
     */
    public function validateJwt(Token $token) : void
    {
        $validator = new Validator($token);
        $signer = new Hmac(self::ALGO);

        // Validate token
        $validator
            ->validateSignature($signer, $this->config->auth->key)
            ->validateIssuer($this->config->application->domain)
            ->validateExpiration(time());

        if ($validator->getErrors()) {
            throw new ServiceException(
                'Bad token',
                self::ERROR_BAD_TOKEN
            );
        }

    }

    /**
     * Get authorization header
     * @return false|string
     */
    public function getAuthorizationToken(): bool|string
    {
        // Get jwt (refreshToken) from Authorization header
        $authorizationHeader = $this->request->getHeader('Authorization');

        if ($authorizationHeader and preg_match('/Bearer\s(\S+)/', $authorizationHeader, $matches)) {
            return $matches[1];
        } else {
            return false;
        }
    }


}