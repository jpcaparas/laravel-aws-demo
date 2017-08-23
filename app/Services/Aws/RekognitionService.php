<?php

namespace App\Services\Aws;

use Aws\Rekognition\RekognitionClient;
use Aws\Rekognition\Exception\RekognitionException;
use Symfony\Component\HttpFoundation\File\File;

/**
 * Class RekognitionService
 *
 * @package App\Services\Aws
 */
class RekognitionService extends AwsService
{
    /**
     * @var array
     */
    private $config = [];

    /**
     * @var RekognitionClient
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
     * @return RekognitionClient
     */
    public function getClient(): RekognitionClient
    {
        if ($this->client === null) {
            $this->client = new RekognitionClient($this->getConfig());
        }

        return $this->client;
    }

    /**
     * @param RekognitionClient $client
     */
    public function setClient(RekognitionClient $client)
    {
        $this->client = $client;
    }

    /**
     * Upload a file
     *
     * @param File $file
     *
     * @return bool
     */
    public function recognizeCelebrities(File $file)
    {
        try {
            $resource = fopen($file, 'r', true);
            $image = stream_get_contents($resource);

            $response = $this->getClient()->recognizeCelebrities([
                'Image' => [
                    'Bytes' => $image
                ]
            ]);

            $this->setLastResponse($response);
        } catch (RekognitionException $e) {
            $this->setLastError($e->getMessage());

            return false;
        }

        return true;
    }
}
