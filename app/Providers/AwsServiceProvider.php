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
        $this->app->bind(S3Service::class, function() {
            $config = new S3Config();

            $s3 = new S3Service();
            $s3->setConfig($config);

            return $s3;
        });

        // Rekognition
        $this->app->bind(RekognitionService::class, function() {
            $config = [
                'version' => config('aws.rekognition.version'),
                'region'  => config('aws.rekognition.region')
            ];

            $rekognition = new RekognitionService();
            $rekognition->setConfig($config);

            return $rekognition;
        });

        // Elastic Transcoder
        $this->app->bind(EtService::class, function(Application $app) {
            $et = new EtService();

            $config = [
                'version' => config('aws.et.version'),
                'region'  => config('aws.et.region')
            ];

            $et->setConfig($config);
            $et->setS3($app->make(S3Service::class));

            return $et;
        });
    }
}
