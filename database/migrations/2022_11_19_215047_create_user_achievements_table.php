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
        Schema::create('user_achievements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('achievement_id')->constrained('achievements');
            $table->integer('points');
            // todo: zatím dočasně
            $table->integer('prev_state')->default(null)->nullable();
            $table->integer('new_state')->default(null)->nullable();
            $table->json('friendsToCheck')->default(null)->nullable();

            $table->foreignId('status_id')->constrained('user_achievements_status');
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
        Schema::dropIfExists('user_achievements');
    }
};
