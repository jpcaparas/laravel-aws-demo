<?php

namespace App\Http\Controllers\Aws;

use App\Models\TranscodingJob;
use App\Services\TranscodingJobService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * Class EtTranscodeSubscriberController
 *
 * @package App\Http\Controllers\Aws
 */
class EtTranscodeSubscriberController extends Controller
{
    public function __invoke(Request $request, TranscodingJobService $transcodingJobService)
    {
        $payload = json_decode($request->getContent(), true) ?? [];

        logger('AWS Elastic Transcoder Payload.', $payload);

        // Ping subscription URL (if specified)
        if (isset($payload['SubscribeURL']) === true) {
            file_get_contents($payload['SubscribeURL']);
        }

        if (empty($payload['Message'])) {
            return $this->sendResponse($payload);
        }

        $data = json_decode(stripslashes($payload['Message']), true) ?? null;

        if (empty($data) === true) {
            return $this->sendErrors([null]);
        }

        $jobId = $data['jobId'] ?? null;

        if (empty($jobId) === true) {
            return $this->sendErrors([null]);
        }

        /**
         * @var TranscodingJob $job
         */
        $job = TranscodingJob::where('job_id', '=', $jobId)->first();

        if (empty($job) === true) {
            return $this->sendErrors([null]);
        }

        if (strtolower($data['state']) === 'completed') {
            $transcodingJobService->markAsCompleted($job);

            // TODO email notification
        }

        return $this->sendResponse($payload);
    }
}
