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
        Schema::table('student_payment_done', function (Blueprint $table) {
            $table->foreignId('student_payment_types_id')->references('id')->on('student_payment_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_payment_done', function (Blueprint $table) {
            $table->dropForeign(['student_payment_types_id']);
        });
    }
};
