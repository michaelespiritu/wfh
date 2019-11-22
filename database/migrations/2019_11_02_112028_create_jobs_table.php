<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('job_openings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('identifier')->unique(); 
            $table->timestamp('expiration')->nullable();
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('category_id');
            $table->string('title');
            $table->string('type'); //full time or part time
            $table->string('region_restriction')->nullable();
            $table->string('notify_email');
            $table->text('budget');
            $table->text('skills')->nullable();
            $table->text('description');
            $table->timestamps();

            $table->foreign('owner_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('categories');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('job_openings');
    }
}
