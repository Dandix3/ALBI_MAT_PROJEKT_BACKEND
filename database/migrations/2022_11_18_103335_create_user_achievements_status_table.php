<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('user_achievements_status', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('title');
            $table->timestamps();
        });

        DB::table('user_achievements_status')->insert([
            ['name' => 'created', 'title' => 'Úspěch vytvořen'],
            ['name' => 'in_progress', 'title' => 'Úspěch v průběhu'],
            ['name' => 'completed', 'title' => 'Úspěch splněn'],

            ['name' => 'waiting_for_check', 'title' => 'Čeká na kontrolu'],
            ['name' => 'checked', 'title' => 'Kontrola dokončena'],
            ['name' => 'rejected', 'title' => 'Odmítnuto'],
            ['name' => 'accepted', 'title' => 'Přijato'],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_achievements_status');
    }
};
