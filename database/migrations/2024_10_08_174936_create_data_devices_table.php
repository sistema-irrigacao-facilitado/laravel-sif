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
        Schema::create('data_devices', function (Blueprint $table) {
            $table->id();
        $table->float('humidity');
            $table->float('temperature');
            $table->float('liters_pump');
            $table->timestamps();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->foreignId('average_data_id')->nullable()->constrained('average_data')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_devices');
    }
};
