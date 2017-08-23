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
    public function __invoke(S3Service $s3)
    {
        $downloadDir = storage_path('aws/s3/' . config('aws.s3.bucket_name'));
        $s3->download($downloadDir);

        $response = [
            'data' => [
                'download_dir' => $downloadDir
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
