<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tv_shows', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tmdb_id')->unique();
            $table->string('name');
            $table->string('slug');
            $table->string('created_year')->nullable();
            $table->string('first_air_date')->nullable();
            $table->decimal('rating', 8, 1);
            $table->unsignedSmallInteger('rate_count')->nullable();
            $table->boolean('adult')->nullable();
            $table->smallInteger('episode_run_time')->nullable();
            $table->integer('number_of_episodes')->nullable();
            $table->integer('number_of_seasons')->nullable();
            $table->string('poster_path');
            $table->bigInteger('visits')->default(1);
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
        Schema::table('seasons', function (Blueprint $table) {
            $table->dropForeign(['tv_show_id']);
        });
        Schema::dropIfExists('tv_shows');
    }
};
