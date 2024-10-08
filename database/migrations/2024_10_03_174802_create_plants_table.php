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
        Schema::create('plants', function (Blueprint $table) {
            $table->id();
            $table->string('icommon_namep', 255);
            $table->string('scientific_name', 255);
            $table->enum('water_need', ['small','medium','tall']);
            $table->enum('soil_type', ['sandy','clayey','humus','calcareous']);
            $table->integer('humidity_tolerance');
            $table->integer('temperature_tolerance');
            $table->binary('image');

            $table->integer('status');
            $table->string('obs', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
        Schema::dropIfExists('plants');
    }
};
