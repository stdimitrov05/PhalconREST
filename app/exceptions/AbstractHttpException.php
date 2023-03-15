<?php

namespace App\Exceptions;

use Exception;

/**
 * Class AbstractHttpException
 * Runtime Exceptions
 */
abstract class AbstractHttpException extends \RuntimeException
{
    /**
     * Possible fields in the answer body
     */
    const KEY_STATUS = 'status';
    const KEY_CODE = 'code';
    const KEY_MESSAGE = 'message';
    const KEY_DETAILS = 'data';

    /**
     * http result code
     *
     * @var int|null
     */
    protected ?int $httpCode = null;

    /**
     * http error message
     *
     * @var string|null
     */
    protected ?string $httpMessage = null;

    /**
     * Error info
     *
     * @var array
     */
    protected array $appError = [];

    /**
     * @param string|null $appErrorMessage Exception message
     * @param int|null $appErrorCode Exception code
     * @param Exception|null $previous Chain of exceptions
     *
     */
    public function __construct(string $appErrorMessage = null, int $appErrorCode = null, Exception $previous = null)
    {
        if (is_null($this->httpCode) || is_null($this->httpMessage)) {
            throw new \RuntimeException('HttpException without httpCode or httpMessage');
        }

        /**
         * Sending ServiceExceptions along the chain
         */
        if ($previous instanceof ServiceException) {
            if (is_null($appErrorCode)) {
                $appErrorCode = $previous->getCode();
            }

            if (is_null($appErrorMessage)) {
                $appErrorMessage = $previous->getMessage();
            }
        }

        $this->appError = [
            self::KEY_STATUS => $this->httpCode == 400 ? 'fail' : 'error',
            self::KEY_CODE => $appErrorCode,
            self::KEY_MESSAGE => $appErrorMessage
        ];

        parent::__construct($this->httpMessage, $this->httpCode, $previous);
    }

    /**
     * Returns client error
     *
     * @return array|null
     */
    public function getAppError(): ?array
    {
        return $this->appError;
    }

    /**
     * Adding error array
     *
     * @param array $fields Array with errors
     *
     * @return $this
     */
    public function addErrorDetails(array $fields): AbstractHttpException
    {
        if (array_key_exists(self::KEY_DETAILS, $this->appError)) {
            $fields = array_merge($this->appError[self::KEY_DETAILS], $fields);
        }
        $this->appError[self::KEY_DETAILS] = $fields;

        // For throw
        return $this;
    }
}
