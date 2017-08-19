<?php

namespace App\Http\Controllers\Aws\Support;

use App\Services\Aws\RekognitionService;
use App\Services\Aws\S3Service;

/**
 * Trait UsesRekognition
 *
 * @package App\Http\Controllers\Aws\Support
 */
trait UsesRekognition
{
    /**
     * @var RekognitionService
     */
    private $rekognition;

    /**
     * @return RekognitionService
     */
    public function getRekognition(): RekognitionService
    {
        return $this->rekognition;
    }

    /**
     * @param RekognitionService $rekognition
     */
    public function setRekognition(RekognitionService $rekognition)
    {
        $this->rekognition = $rekognition;
    }
}
