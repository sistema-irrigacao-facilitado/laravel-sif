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
            $table->string('common_name', 255);
            $table->string('scientific_name', 255);
            $table->enum('water_need', ['low','medium','high']);
            $table->enum('soil_type', ['sandy','clayey','humus','calcareous']);
            $table->integer('humidity_tolerance');
            $table->integer('temperature_tolerance');
            $table->longText('image')->nullable();

            $table->integer('status')->default(2);
            $table->string('obs', 255)->nullable();
            $table->timestamps();
            $table->softDeletes();
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
