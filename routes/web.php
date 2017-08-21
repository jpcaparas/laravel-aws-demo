<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::group(['prefix' => 'aws', 'namespace' => 'Aws'], function () {
    Route::group(['prefix' => 's3'], function () {
        Route::post('upload', 'S3UploadController')->name('aws.s3.upload.store');
        Route::post('download_bucket', 'S3DownloadBucketController')->name('aws.s3.download_bucket.store');
    });

    Route::group(['prefix' => 'rekognition'], function () {
        Route::post('recognize_celebrities',
            'RekognitionRecognizeCelebritiesController')->name('aws.rekognition.recognize_celebrities');
    });
});
