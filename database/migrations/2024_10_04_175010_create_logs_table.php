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
        Schema::create('logs', function (Blueprint $table) {
            $table->id();
            $table->enum('causer_type', ['user', 'collaborator', 'registration']);
            $table->integer('causer_id');
            $table->enum('accomplished_type', ['user', 'collaborator', 'device', 'plant', 'pump']);
            $table->integer('accomplished_id');
            $table->json('before');
            $table->json('after');

            $table->string('obs', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logs');
    }
};
