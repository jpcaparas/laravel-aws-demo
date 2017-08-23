<?php

namespace App\Http\Controllers\Aws;

use App\Http\Requests\Aws\EtTranscodeRequest;
use App\Models\Media;
use App\Models\TranscodingJob;
use App\Services\Aws\EtService;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;

/**
 * Class EtTranscodeController
 *
 * @package App\Http\Controllers\Aws
 */
class EtTranscodeController extends Controller
{
    public function __invoke(EtTranscodeRequest $request, EtService $et)
    {
        /**
         * @var UploadedFile $file
         */
        $file = $request->file('file');
        $path = $file->store('uploads/videos');

        if (empty($path) === true) {
            throw new \RuntimeException('Failed to upload file.');
        }

        // Save Media to DB
        $media = new Media();
        $media->name = $file->getClientOriginalName();
        $media->path = $path;
        $media->mime_type = $file->getMimeType();
        $media->size = $file->getSize();
        $media->saveOrFail();

        $filename = basename($media->path);

        $et->transcode($file, $filename);
        $etResponse = $et->getLastResponse();

        $status = Response::HTTP_OK;

        if ($etResponse === null) {
            $response = [
                'errors' => ['aws' => $et->getLastError()]
            ];

            $status = Response::HTTP_UNPROCESSABLE_ENTITY;
        } else {
            // Save job to DB
            $etResponse = $etResponse->toArray();
            $job = new TranscodingJob();
            $job->job_id = $etResponse['Job']['Id'];
            $job->properties = $etResponse['Job'];
            $job->started_at = Carbon::now();
            $job->region = config('aws.et.region');
            $job->bucket_in = config('aws.et.bucket_in');
            $job->bucket_out = config('aws.et.bucket_out');
            $job->bucket_thumbs = config('aws.et.bucket_thumbs');
            $job->media()->associate($media);
            $job->save();

            $response = [
                'data' => $etResponse
            ];
        }

        return response()->json($response, $status);
    }
}
