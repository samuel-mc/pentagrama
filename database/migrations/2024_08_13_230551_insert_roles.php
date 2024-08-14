<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('roles')->insert([
            'name' => 'Administrado',
            'need_login' => true,
            'created_at' => now(),
            'updated_at' => now(),
            'active' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'Recepcionista',
            'need_login' => true,
            'created_at' => now(),
            'updated_at' => now(),
            'active' => true,
        ]);
        DB::table('roles')->insert([
            'name' => 'Limpieza',
            'need_login' => false,
            'created_at' => now(),
            'updated_at' => now(),
            'active' => true,
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('roles')->where('name', 'Administrado')->delete();
        DB::table('roles')->where('name', 'Recepcionista')->delete();
        DB::table('roles')->where('name', 'Limpieza')->delete();
    }
};
