<?php

namespace App\Services\Aws;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class S3Service
 *
 * @package Services\Aws\S3
 *
 */
class S3Service extends AwsService
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @var string
     */
    private $acl;

    /**
     * @var string
     */
    private $bucketName;

    /**
     * @var S3Client
     */
    private $client;

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * @param array $config
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
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
     * @return S3Client
     *
     * @throws \InvalidArgumentException
     */
    public function getClient(): S3Client
    {
        if ($this->client === null) {
            $this->client = new S3Client($this->getConfig());
        }

        return $this->client;
    }

    /**
     * Upload a file
     *
     * @param File   $file
     * @param string $fileName
     *
     * @return bool
     */
    public function upload(File $file, string $fileName)
    {
        try {
            $response = $this->getClient()->upload(
                $this->getBucketName(),
                $fileName,
                $file->openFile(),
                $this->getAcl()
            );

            $this->setLastResponse($response);
        } catch (S3Exception $e) {
            $this->setLastError($e->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Download a bucket of files into a directory
     *
     * @param string $dir
     * @param string $prefix
     *
     */
    public function download(string $dir, $prefix = '')
    {
        try {
            $this->getClient()->downloadBucket(
                $dir,
                $this->getBucketName(),
                $prefix
            );
        } catch (S3Exception $e) {
            Log::error('S3 bucket download failed.', $e->getMessage());
        }
    }
}
