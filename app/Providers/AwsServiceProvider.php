<?php

namespace App\Providers;

use App\Services\Aws\Config\S3Config;
use App\Services\Aws\EtService;
use App\Services\Aws\RekognitionService;
use App\Services\Aws\S3Service;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class AwsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // S3
        $this->app->bind(S3Service::class, function () {
            $s3 = new S3Service();

            $config = [
                'version' => config('aws.s3.version'),
                'region'  => config('aws.s3.region')
            ];

            $s3->setConfig($config);

            return $s3;
        });

        // Rekognition
        $this->app->singleton(RekognitionService::class, function () {
            $rekognition = new RekognitionService();

            $config = [
                'version' => config('aws.rekognition.version'),
                'region'  => config('aws.rekognition.region')
            ];
            $rekognition->setConfig($config);

            return $rekognition;
        });

        // Elastic Transcoder
        $this->app->singleton(EtService::class, function (Application $app) {
            $et = new EtService();

            $etConfig = [
                'version' => config('aws.et.version'),
                'region'  => config('aws.et.region')
            ];
            $et->setConfig($etConfig);

            $s3 = $app->make(S3Service::class);
            $s3->setConfig($etConfig);
            $s3->setBucketName(config('aws.et.bucket_in'));
            $et->setS3($s3);

            return $et;
        });
    }
}
