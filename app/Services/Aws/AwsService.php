<?php

namespace App\Services\Aws;

use Aws\Result;

/**
 * Class AwsService
 *
 * @package App\Services\Aws
 */
abstract class AwsService
{
    /**
     * @var null|Result
     */
    private $lastResponse;

    /**
     * @var null|string
     */
    private $lastError;

    /**
     * @return null|Result
     */
    public function getLastResponse()
    {
        return $this->lastResponse;
    }

    /**
     * @param null|Result $lastResponse
     */
    public function setLastResponse($lastResponse)
    {
        $this->lastResponse = $lastResponse;
    }

    /**
     * @return null|string
     */
    public function getLastError(): string
    {
        return $this->lastError;
    }

    /**
     * @param null|string $lastError
     */
    public function setLastError($lastError)
    {
        $this->lastError = $lastError;
    }

    /**
     * Check if there is an error
     *
     * @return bool
     */
    public function hasError()
    {
        return is_null($this->lastError) === false;
    }
}
