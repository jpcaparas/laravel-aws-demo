<?php

namespace App\Services\Aws;

use Aws\ElasticTranscoder\ElasticTranscoderClient;
use Aws\ElasticTranscoder\Exception\ElasticTranscoderException;
use Aws\S3\Exception\S3Exception;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class ElasticTranscoderService
 *
 * @package App\Services\Aws
 *
 */
class EtService extends AwsService
{
    private $config = [];

    /**
     * @var ElasticTranscoderClient
     */
    private $client;

    /**
     * @var S3Service
     */
    private $s3;

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
     * @return S3Service
     */
    public function getS3(): S3Service
    {
        return $this->s3;
    }

    /**
     * @param S3Service $s3
     */
    public function setS3(S3Service $s3)
    {
        $this->s3 = $s3;
    }

    /**
     * @return ElasticTranscoderClient
     */
    public function getClient(): ElasticTranscoderClient
    {
        if ($this->client === null) {
            $this->client = new ElasticTranscoderClient($this->getConfig());
        }

        return $this->client;
    }

    /**
     * Transcode a video
     *
     * @param string $key
     * @param File   $file
     *
     * @return bool
     */
    public function transcode(File $file, string $key)
    {
        try {
            $this->getS3()->upload($file, $key);
        } catch (S3Exception $e) {
            $this->setLastError($e->getMessage());

            return false;
        }

        try {
            $response = $this->getClient()->createJob([
                'PipelineId' => config('aws.et.pipeline_id'),
                'Input'      => [
                    'Key' => $key
                ],
                'Outputs'    => [
                    [
                        'PresetId'         => config('aws.et.preset_id'),
                        'Key'              => $key,
                        'ThumbnailPattern' => $key . '/thumbnails/{count}'
                    ]
                ],
            ]);

            $this->setLastResponse($response);
        } catch (ElasticTranscoderException $e) {
            $this->setLastError($e->getMessage());

            return false;
        }

        return true;
    }
}
