<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('student_payment_types')->insert([
            ['name' => 'Inscripción', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Mensualidad', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Otro', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
