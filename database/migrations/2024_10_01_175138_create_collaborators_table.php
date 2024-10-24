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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id();
            $table->string('name', 250);
            $table->string('lastname', 250);
            $table->string('email')->nullable();
            $table->string('password', 70);
            $table->string('telephone', 15);
            $table->string('cpf', 15)->unique();
            $table->string('rg', 15)->unique()->nullable();
            $table->integer('status');
            $table->enum('perfil', ['regular', 'admin']);
            $table->timestamps();
            $table->softDeletes();
            $table->foreignId('collaborators_inclusion_id')->nullable()->constrained('collaborators')->onDelete('cascade');
            $table->foreignId('collaborators_change_id')->nullable()->constrained('collaborators')->onDelete('cascade');
            $table->foreignId('collaborators_exclusion_id')->nullable()->constrained('collaborators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collaborators');
    }
};
