<?php

namespace App\Http\Controllers\Aws;

use App\Models\TranscodingJob;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

/**
 * Class EtTranscodeSubscriberController
 *
 * @package App\Http\Controllers\Aws
 */
class EtTranscodeSubscriberController extends Controller
{
    public function __invoke(Request $request)
    {
        $payload = json_decode($request->getContent(), true);

        Log::debug('AWS Elastic Transcoder Payload.', $payload);

        // Ping subscription URL (if specified)
        if (isset($payload['SubscribeURL']) === true) {
            file_get_contents($payload['SubscribeURL']);
        }

        $data = json_decode(stripslashes($payload['Message']), true) ?? null;

        if (empty($data) === true) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $jobId = $data['jobId'] ?? null;

        if (empty($jobId) === true) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        /**
         * @var TranscodingJob $job
         */
        $job = TranscodingJob::where('job_id', '=', $jobId)->first();

        if (empty($job) === true) {
            return response(null, Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        if (strtolower($data['state']) === 'completed') {
            $job->completed_at = Carbon::now();
            $job->saveOrFail();

            // TODO email notification
        }

        return response()->json($payload);
    }
}
