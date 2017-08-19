<?php

return [
    // Authentication
    'access_key_id'     => env('AWS_ACCESS_KEY_ID', null),
    'secret_access_key' => env('AWS_SECRET_ACCESS_KEY', null),
    'session_token'     => env('AWS_SESSION_TOKEN', null),

    // S3 service
    's3'                => [
        'version'     => env('AWS_S3_VERSION', 'latest'),
        'region'      => env('AWS_S3_REGION', 'ap-southeast-2'),
        'bucket_name' => env('AWS_S3_BUCKET_NAME', null),
        'acl'         => env('AWS_S3_ACL', 'public-read'),
        'credentials' => [
            'key'    => env('AWS_ACCESS_KEY_ID', null),
            'secret' => env('AWS_SECRET_ACCESS_KEY', null),
        ],
    ],

    // Rekognition
    'rekognition'       => [
        'version' => env('AWS_REKOGNITION_VERSION', 'latest'),
        'region'  => env('AWS_REKOGNITON_REGION', 'us-east-1')
    ]
];
