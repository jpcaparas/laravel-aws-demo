<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranscodingJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transcoding_jobs', function (Blueprint $table) {
            $table->increments('id');

            $table->string('job_id');
            $table->text('properties')->nullable();
            $table->text('region')->nullable();
            $table->text('bucket_in')->nullable();
            $table->text('bucket_out')->nullable();
            $table->text('bucket_thumbs')->nullable();
            $table->dateTime('started_at')->nullable();
            $table->dateTime('completed_at')->nullable();
            $table->integer('media_id')->unsigned();

            $table->foreign('media_id')
                  ->references('id')->on('media')
                  ->onDelete('cascade');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transcoding_jobs');
    }
}
