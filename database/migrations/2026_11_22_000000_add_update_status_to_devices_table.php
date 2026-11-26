<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

// A coluna update_status já é usada pelo código e existe no laravel.sql,
// mas não tinha migration: quem subia o banco só pelas migrations ficava sem ela.
return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('devices', 'update_status')) {
            Schema::table('devices', function (Blueprint $table) {
                $table->integer('update_status')->default(1)->after('status');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('devices', 'update_status')) {
            Schema::table('devices', function (Blueprint $table) {
                $table->dropColumn('update_status');
            });
        }
    }
};
