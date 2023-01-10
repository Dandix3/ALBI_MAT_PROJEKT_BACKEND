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
//        Schema::create('activity_log_action_types', function (Blueprint $table) {
//            $table->string('name')->primary();
//            $table->string('title');
//
//            $table->timestamps();
//        });
//
//        ActivityLogActionType::insert([
//            ['name' => ActivityLogActionType::TYPE_HU_CREATED, 'title' => 'Vyskladněno'],
//            ['name' => ActivityLogActionType::TYPE_HU_LOADED, 'title' => 'Naloženo'],
//            ['name' => ActivityLogActionType::TYPE_HU_SCANNED, 'title' => 'Naskenováno'],
//            ['name' => ActivityLogActionType::TYPE_HU_DELIVERED, 'title' => 'Doručeno'],
//            ['name' => ActivityLogActionType::TYPE_HU_CANCELLED, 'title' => 'Doručování zrušeno'],
//        ]);
//
//
//        Schema::create('activity_log', function (Blueprint $table) {
//            $table->id();
//            $table->foreignId('user_id')->constrained('users');
//
//            $table->timestamps();
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('activity_log');
    }
};
