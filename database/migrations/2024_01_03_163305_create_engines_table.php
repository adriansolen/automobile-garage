<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('engines', function (Blueprint $table) {
            $table->id("engine_id");
            $table->string("engine_type");
            $table->string("displacement");
            $table->string("maximum_output");
            $table->string("maximum_torque");
            $table->string("fuel_type");
            $table->string("fuel_capacity");
            $table->timestamps();
        });

        Schema::table('engines', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('VIN');
            $table->foreign('VIN')->references('VIN')->on('vehicles');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('engines');
    }
};
