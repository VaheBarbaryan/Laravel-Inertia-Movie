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
        Schema::create('casts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('tmdb_id')->unique();
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->text('biography')->nullable();
            $table->date('birthday')->nullable();
            $table->date('deathday')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('poster_path')->nullable();
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
        Schema::dropIfExists('casts');
    }
};
