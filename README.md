# Laravel AWS demo

![aws-logo](http://i.imgur.com/omj568G.png)

A demo illustrating how to integrate Laravel with the AWS suite.

## Services

These services (segmented via URIs) are currently available to test:

|   Method    |   URI                                       |
|   ------    |   ---                                       |
|   `POST`    |   `aws/s3/upload`                           |
|   `POST`    |   `aws/s3/download_bucket`                  |
|   `POST`    |   `aws/rekognition/recognize_celebrities`   |
|   `POST`    |   `aws/et/transcode`                        |
|   `POST`    |   `aws/et/transcode/subscriber`             |

## Initial set up

1. Bootstrap the project
        
        composer create-project jpcaparas/laravel-aws-demo --prefer-dist

1. Run tests
        
        vendor/bin/phpunit
        
1. Populate the `.env` file with your AWS credentials. [Sign up for AWS](http://docs.aws.amazon.com/lambda/latest/dg/setting-up.html) if you haven't done so already.
