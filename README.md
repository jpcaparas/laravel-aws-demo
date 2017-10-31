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

## Requirements

1. PHP 7.x
1. SQLite 3.x

## Initial set up

1. Bootstrap the project
        
        composer create-project jpcaparas/laravel-aws-demo --prefer-dist
        
        touch database/database.sqlite
        
        php artisan migrate:refresh --seed

1. Run tests (somewhat non-existent for the meantime)
        
        vendor/bin/phpunit
        
1. Populate the `.env` file with your AWS credentials. [Sign up for AWS](http://docs.aws.amazon.com/lambda/latest/dg/setting-up.html) if you haven't done so already.

## All set? Trying it all out

📘 👉 Ready to roll? Head on over to [the wiki](https://github.com/jpcaparas/laravel-aws-demo/wiki).

##  Additional services used

- [Ngrok](https://ngrok.com/) - A freemium service used to give your app a public-facing URL. This allows Amazon to send webhooks to your app.
- [Postman](https://www.getpostman.com/) - A free tool for testing API endpoints. Support sending multipart requests (e.g. file uploads).

## Disclaimer

A few commands issued throughout this demo are for `*nix` systems (e.g. macOS, Ubuntu), so your mileage may vary if you're using Windows.

## Attributions

![figured-logo](https://www.figured.com/assets/img/figured-logo@2x.png)

I am a product developer for [Figured, Ltd](https://www.figured.com), a cloud-based farm financial management software company disrupting the agriculture industry. We're headquartered at Victoria Street West, Auckland.

We leverage AWS as part of our development toolchain to offload complexity onto the cloud. This in turn makes us focus on building new features, leading to happy developers and a rapidly evolving product.
