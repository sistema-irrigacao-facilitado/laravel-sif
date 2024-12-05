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
        Schema::create('pumps', function (Blueprint $table) {
            $table->id();
            $table->string('model', 255);
            $table->float('flow');
            $table->longText('image')->charset('binary')->nullable();
            $table->integer('status');
            $table->string('obs', 255)->nullable();

            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('collaborators_inclusion_id')->constrained('collaborators')->onDelete('cascade');
            $table->foreignId('collaborators_change_id')->nullable()->constrained('collaborators')->onDelete('cascade');
            $table->foreignId('collaborators_exclusion_id')->nullable()->constrained('collaborators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pumps');
    }
};
