<?php

namespace App\Services\Aws\Config;

/**
 * Class S3Config
 *
 * @package App\Services\Aws\Config
 */
class S3Config
{
    /**
     * @var string
     */
    private $bucketName;

    /**
     * @var string
     */
    private $version;

    /**
     * @var string
     */
    private $region;

    /**
     * @var string
     */
    private $acl;

    /**
     * @return string
     */
    public function getBucketName(): string
    {
        return $this->bucketName ?? config('aws.s3.bucket_name');
    }

    /**
     * @param string $bucketName
     */
    public function setBucketName(string $bucketName)
    {
        $this->bucketName = $bucketName;
    }

    /**
     * @return string
     */
    public function getVersion(): string
    {
        return $this->version ?? config('aws.s3.version');
    }

    /**
     * @param string $version
     */
    public function setVersion(string $version)
    {
        $this->version = $version;
    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region ?? config('aws.s3.region');
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region)
    {
        $this->region = $region;
    }

    /**
     * @return string
     */
    public function getAcl(): string
    {
        return $this->acl ?? config('aws.s3.acl');
    }

    /**
     * @param string $acl
     */
    public function setAcl(string $acl)
    {
        $this->acl = $acl;
    }
}