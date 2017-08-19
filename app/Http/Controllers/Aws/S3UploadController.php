<?php

namespace App\Http\Controllers\Aws;

use App\Http\Requests\Aws\S3UploadRequest;
use App\Services\Aws\S3UploadService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

/**
 * Class S3UploadController
 *
 * @package App\Http\Controllers\Aws
 */
class S3UploadController extends Controller
{
    /**
     * @var S3UploadService
     */
    private $service;

    public function __construct()
    {
        $this->setService(new S3UploadService());
    }

    public function __invoke(S3UploadRequest $request)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');
        $fileName = str_slug($request->input('file_name'))
                    . '_' . Carbon::now()->timestamp
                    . '.' . $file->getClientOriginalExtension();

        $s3 = $this->getService();
        $s3->upload($file, $fileName);
        $s3Response = $s3->getLastResponse();

        $status = Response::HTTP_OK;

        if ($s3Response === null) {
            $response = [
                'errors' => [ 'aws' => $s3->getLastError() ]
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            $response = [
                'data' => $s3->getLastResponse()->toArray(),
            ];
        }


        return response()->json($response, $status);
    }

    /**
     * @return S3UploadService
     */
    public function getService(): S3UploadService
    {
        return $this->service;
    }

    /**
     * @param S3UploadService $service
     */
    public function setService(S3UploadService $service)
    {
        $this->service = $service;
    }
}
