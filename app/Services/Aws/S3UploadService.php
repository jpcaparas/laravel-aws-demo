<?php

namespace App\Services\Aws;

use Aws\S3\Exception\S3Exception;
use Aws\S3\S3Client;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class S3UploadService
 *
 * @package Services\Aws\S3
 *
 */
class S3UploadService extends AwsService
{
    /**
     * @var S3Client
     */
    private $client;

    /**
     * S3UploadService constructor.
     */
    public function __construct()
    {
        $args = [
            'version' => config('aws.s3.version'),
            'region'  => config('aws.s3.region')
        ];

        $this->setClient(new S3Client($args));
    }

    /**
     * @return S3Client
     */
    public function getClient(): S3Client
    {
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
     * @param File $file
     * @param string       $fileName
     *
     * @return bool
     */
    public function upload(File $file, string $fileName)
    {
        try {
            $response = $this->getClient()->upload(
                config('aws.s3.bucket_name'),
                $fileName,
                $file->openFile(),
                config('aws.s3.acl')
            );

            $this->setLastResponse($response);
        } catch (S3Exception $e) {
            $this->setLastError($e->getMessage());

            return false;
        }

        return true;
    }
}
