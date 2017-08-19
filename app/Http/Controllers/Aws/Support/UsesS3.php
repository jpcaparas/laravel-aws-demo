<?php

namespace App\Http\Controllers\Aws\Support;

use App\Services\Aws\S3Service;

trait UsesS3
{
    /**
     * @var S3Service
     */
    private $s3;

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
}
