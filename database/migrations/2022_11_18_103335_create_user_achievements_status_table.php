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
            $table->string('description');
            $table->timestamps();
        });

        DB::table('user_achievements_status')->insert([
            ['name' => 'created', 'description' => 'Úspěch vytvořen'],
            ['name' => 'in_progress', 'description' => 'Úspěch v průběhu'],
            ['name' => 'completed', 'description' => 'Úspěch splněn'],

            ['name' => 'waiting_for_check', 'description' => 'Čeká na kontrolu'],
            ['name' => 'checked', 'description' => 'Kontrola dokončena'],
            ['name' => 'rejected', 'description' => 'Odmítnuto'],
            ['name' => 'accepted', 'description' => 'Přijato'],
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
