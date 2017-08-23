<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasTimestamps;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class TranscodingJob
 *
 * @property string $job_id
 * @property string $notify
 * @property array $properties
 * @property string $url
 * @property string $region
 * @property string $bucket_in
 * @property string $bucket_out
 * @property string $bucket_thumbs
 * @property int $media_id
 * @property string $started_at
 * @property string $completed_at
 *
 * @package App\Models
 *
 */
class TranscodingJob extends Model
{
    use HasTimestamps, SoftDeletes;

    protected $fillable = [
        'job_id',
        'properties',
        'size',
        'region',
        'bucket_in',
        'bucket_out',
        'bucket_thumbs',
        'url',
        'media_id',
        'started_at',
        'completed_at',
    ];

    protected $dates = ['started_at', 'completed_at'];

    protected $casts = [
        'properties' => 'array'
    ];

    /**
     * @return BelongsTo
     */
    public function media()
    {
        return $this->belongsTo(Media::class);
    }
}
