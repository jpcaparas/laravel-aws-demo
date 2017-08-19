<?php

namespace App\Http\Controllers\Aws;

use App\Services\Aws\S3Service;
use Illuminate\Http\Response;

/**
 * Class S3DownloadBucketController
 *
 * @package App\Http\Controllers\Aws
 */
class S3DownloadBucketController extends Controller
{
    /**
     * @var S3Service
     */
    private $service;

    public function __construct()
    {
        $this->setService(new S3Service());
    }

    public function __invoke()
    {
        $downloadDir = storage_path('aws/s3/' . config('aws.s3.bucket_name'));
        $s3 = $this->getService();
        $s3->download($downloadDir);

        $response = [
            'data' => [
                'download_dir' => $downloadDir
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }

    /**
     * @return S3Service
     */
    public function getService(): S3Service
    {
        return $this->service;
    }

    /**
     * @param S3Service $service
     */
    public function setService(S3Service $service)
    {
        $this->service = $service;
    }
}
