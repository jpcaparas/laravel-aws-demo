<?php

namespace App\Http\Controllers\Aws;

use App\Http\Requests\Aws\RekognitionRequest;
use App\Services\Aws\RekognitionService;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

/**
 * Class RekognitionRecognizeCelebritiesController
 *
 * @package App\Http\Controllers\Aws
 */
class RekognitionRecognizeCelebritiesController extends Controller
{
    public function __invoke(RekognitionRequest $request, RekognitionService $rekognition)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');

        $rekognition->recognizeCelebrities($file);
        $rekognitionResponse = $rekognition->getLastResponse();

        $status = Response::HTTP_OK;

        if ($rekognitionResponse === null) {
            $response = [
                'errors' => [ 'aws' => $rekognition->getLastError() ]
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            $response = [
                'data' => $rekognition->getLastResponse()->toArray(),
            ];
        }

        return response()->json($response, $status);
    }
}
