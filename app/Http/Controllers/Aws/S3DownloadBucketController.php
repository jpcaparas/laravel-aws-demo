<?php

namespace App\Http\Controllers\Aws;

use App\Http\Controllers\Aws\Support\UsesS3;
use App\Services\Aws\S3Service;
use Illuminate\Http\Response;

/**
 * Class S3DownloadBucketController
 *
 * @package App\Http\Controllers\Aws
 */
class S3DownloadBucketController extends Controller
{
    use UsesS3;

    public function __construct()
    {
        $this->setS3(new S3Service());
    }

    public function __invoke()
    {
        $downloadDir = storage_path('aws/s3/' . config('aws.s3.bucket_name'));
        $s3 = $this->getS3();
        $s3->download($downloadDir);

        $response = [
            'data' => [
                'download_dir' => $downloadDir
            ],
        ];

        return response()->json($response, Response::HTTP_OK);
    }
}
