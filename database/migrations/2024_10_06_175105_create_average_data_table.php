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
        Schema::create('average_data', function (Blueprint $table) {
            $table->id();
            $table->json('humidity');
            $table->json('temperature');
            $table->json('liters');
            $table->json('data');
            $table->float('average_humidity')->nullable();
            $table->float('average_temperature')->nullable();
            $table->float('average_liters')->nullable();

            $table->foreignId('devices_id')->constrained('devices')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('average_data');
    }
};
