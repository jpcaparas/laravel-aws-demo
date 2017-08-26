<?php

namespace App\Services;

use App\Models\Media;
use App\Models\TranscodingJob;
use Carbon\Carbon;

/**
 * Class TranscodingJobService
 *
 * @package App\Services
 */
class TranscodingJobService
{
    /**
     * @param array $data
     * @param Media $media
     *
     * @return TranscodingJob
     */
    public function create(array $data = [], Media $media)
    {
        $job = new TranscodingJob();
        $job->job_id = $data['job_id'];
        $job->properties = $data;
        $job->started_at = Carbon::now();
        $job->region = config('aws.et.region');
        $job->bucket_in = config('aws.et.bucket_in');
        $job->bucket_out = config('aws.et.bucket_out');
        $job->bucket_thumbs = config('aws.et.bucket_thumbs');
        $job->media()->associate($media);
        $job->saveOrFail();

        return $job;
    }

    /**
     * @param TranscodingJob $job
     *
     * @return TranscodingJob
     */
    public function markAsCompleted(TranscodingJob $job)
    {
        $job->completed_at = Carbon::now();
        $job->saveOrFail();

        return $job;
    }
}
