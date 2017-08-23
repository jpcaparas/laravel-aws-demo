<?php

namespace App\Services\Aws;

use App\Services\Aws\Config\S3Config;
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
     * @var S3Client
     */
    private $client;

    /**
     * @var S3Config
     */
    private $config;

    /**
     * @return S3Config
     */
    public function getConfig(): S3Config
    {
        return $this->config;
    }

    /**
     * @param S3Config $config
     */
    public function setConfig(S3Config $config)
    {
        $this->config = $config;
    }

    /**
     * @return S3Client
     */
    public function getClient(): S3Client
    {
        if ($this->client === null) {
            $configClass = $this->getConfig();

            $config = [
                'region' => $configClass->getRegion(),
                'version' => $configClass->getVersion(),
            ];

            $this->client = new S3Client($config);
        }

        return $this->client;
    }

    /**
     * @param S3Client $client
     */
    public function setClient(S3Client $client)
    {
        $this->client = $client;
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
                $this->getConfig()->getBucketName(),
                $fileName,
                $file->openFile(),
                $this->getConfig()->getAcl()
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
                $this->getConfig()->getBucketName(),
                $prefix
            );
        } catch (S3Exception $e) {
            Log::error('S3 bucket download failed.', $e->getMessage());
        }
    }
}
