<?php

namespace App\Http\Controllers\Aws;

use App\Http\Controllers\Aws\Support\UsesRekognition;
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
    use UsesRekognition;

    public function __construct()
    {
        $this->setRekognition(new RekognitionService());
    }

    public function __invoke(RekognitionRequest $request)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');

        $rekognition = $this->getRekognition();
        $this->getRekognition()->recognizeCelebrities($file);

        return response()->json([
            'data' => $rekognition->getLastResponse()->toArray()
        ], Response::HTTP_OK);
    }
}
