<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInfluencerPersonalizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('influencer_personalizes', function (Blueprint $table) {
            $table->id();
            $table->integer('influencer_id')->nullable();
            $table->string('photo_with_watermark')->nullable();
            $table->string('photo_with_out_watermark')->nullable();
            $table->string('video_with_watermark')->nullable();
            $table->string('video_with_out_watermark')->nullable();
            $table->string('facebook_price')->nullable();
            $table->string('instagram_price')->nullable();
            $table->string('twitter_price')->nullable();
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
        Schema::dropIfExists('influencer_personalizes');
    }
}
