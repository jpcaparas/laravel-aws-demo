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
     * @var RekognitionClient
     */
    private $client;

    /**
     * S3Service constructor.
     */
    public function __construct()
    {
        $args = [
            'version' => config('aws.rekognition.version'),
            'region'  => config('aws.rekognition.region')
        ];

        $this->setClient(new RekognitionClient($args));
    }

    /**
     * @return RekognitionClient
     */
    public function getClient(): RekognitionClient
    {
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
