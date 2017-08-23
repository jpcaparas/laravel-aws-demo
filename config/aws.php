<?php

return [
    // Authentication
    'access_key_id'     => env('AWS_ACCESS_KEY_ID', null),
    'secret_access_key' => env('AWS_SECRET_ACCESS_KEY', null),
    'session_token'     => env('AWS_SESSION_TOKEN', null),

    // S3 service
    's3'                => [
        'version'     => env('AWS_S3_VERSION', 'latest'),
        'region'      => env('AWS_S3_REGION', 'us-west-1'),
        'bucket_name' => env('AWS_S3_BUCKET_NAME', null),
        'acl'         => env('AWS_S3_ACL', 'public-read'),
        'credentials' => [
            'key'    => env('AWS_ACCESS_KEY_ID', null),
            'secret' => env('AWS_SECRET_ACCESS_KEY', null),
        ],
    ],

    // Elastic Transcoder
    'et'                => [
        'version'       => env('AWS_ET_VERSION', 'latest'),
        'region'        => env('AWS_ET_REGION', 'us-west-1'),
        'pipeline_id'   => env('AWS_ET_PIPELINE_ID', null),
        'preset_id'     => env('AWS_ET_PRESET_ID', '1351620000001-000061'), // 360p
        'bucket_in'     => env('AWS_ET_BUCKET_IN', null),
        'bucket_out'    => env('AWS_ET_BUCKET_OUT', null),
        'bucket_thumbs' => env('AWS_ET_BUCKET_THUMBS', null),
    ],

    // Rekognition
    'rekognition'       => [
        'version' => env('AWS_REKOGNITION_VERSION', 'latest'),
        'region'  => env('AWS_REKOGNITION_REGION', 'us-east-1')
    ]
];
