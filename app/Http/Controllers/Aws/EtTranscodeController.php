<?php

namespace App\Http\Controllers\Aws;

use App\Http\Requests\Aws\EtTranscodeRequest;

use App\Services\Aws\EtService;
use App\Services\MediaService;
use App\Services\TranscodingJobService;
use Illuminate\Http\File;

/**
 * Class EtTranscodeController
 *
 * @package App\Http\Controllers\Aws
 */
class EtTranscodeController extends Controller
{
    public function __invoke(
        EtTranscodeRequest $request,
        EtService $et,
        MediaService $mediaService,
        TranscodingJobService $transcodingJobService
    ) {
        $media = $mediaService->create($request);
        $file = $media->isLocal() === true
            ? new File(storage_path('app/' . $media->path))
            : null;

        // Transcode file
        $et->transcode($file, basename($media->path));

        if ($et->hasError() === true) {
            $mediaService->delete($media);

            return $this->sendErrors([$et->getLastError()]);
        }

        $etResponse = $et->getLastResponse();
        $etResponse['Job'];
        $etData = [
            'properties' => $etResponse['Job'],
            'job_id'     => $etResponse['Job']['Id']
        ];

        $job = $transcodingJobService->create($etData, $media);

        return $this->sendResponse($job->toArray());
    }
}
