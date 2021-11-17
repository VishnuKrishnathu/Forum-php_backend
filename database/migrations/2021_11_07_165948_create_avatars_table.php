<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAvatarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('avatar', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('seed');
            $table->foreignId('users_id')->references('id')->on('users');
            $table->string('mouth')->nullable();
            $table->string('eyebrows')->nullable();
            $table->string('hair')->nullable();
            $table->string('eyes')->nullable();
            $table->string('nose')->nullable();
            $table->string('ears')->nullable();
            $table->string('shirt')->nullable();
            $table->string('earrings')->nullable();
            $table->string('glasses')->nullable();
            $table->string('facialHair')->nullable();
            $table->string('shirtColor')->nullable();
            $table->string('mouthColor')->nullable();
            $table->string('hairColor')->nullable();
            $table->string('glassesColor')->nullable();
            $table->string('facialHairColor')->nullable();
            $table->string('eyebrowColor')->nullable();
            $table->string('eyeShadowColor')->nullable();
            $table->string('earringColor')->nullable();
            $table->string('baseColor')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('avatar');
    }
}
