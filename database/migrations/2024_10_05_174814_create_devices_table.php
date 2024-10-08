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
            $table->string('ip', 300)->nullable();
            $table->string('model', 255);
            $table->string('numbering', 255);
            $table->binary('qr')->nullable();
            $table->enum('mode', ['1', '2'])->default('1');
            $table->time('time_on')->nullable();
            $table->integer('status');

            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('users_id')->constrained('users')->onDelete('cascade')->nullable();
            $table->foreignId('plants_id')->constrained('plants')->onDelete('cascade')->nullable();
            $table->foreignId('pumps_id')->constrained('pumps')->onDelete('cascade')->nullable();
            $table->foreignId('collaborators_inclusion_id')->constrained('collaborators')->onDelete('cascade');
            $table->foreignId('collaborators_change_id')->constrained('collaborators')->onDelete('cascade')->nullable();
            $table->foreignId('collaborators_exclusion_id')->constrained('collaborators')->onDelete('cascade')->nullable();
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
