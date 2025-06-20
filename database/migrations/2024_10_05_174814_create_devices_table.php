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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('model', 255);
            $table->string('numbering', 8);
            $table->longText('qr')->binary()->nullable();
            $table->enum('mode', [1, 2])->default(1);
            $table->json('time_on')->nullable();
            $table->string('period', 200)->nullable();
            $table->integer('status')->default(0);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('plant_id')->nullable()->constrained('plants')->onDelete('cascade');
            $table->foreignId('pump_id')->nullable()->constrained('pumps')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
