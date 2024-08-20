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

        //Remove the foreign key student_payment_types_id
        Schema::table('student_payment_done', function (Blueprint $table) {
            $table->dropForeign(['student_payment_types_id']);
        });

        //Remove the column student_payment_types_id
        Schema::table('student_payment_done', function (Blueprint $table) {
            $table->dropColumn('student_payment_types_id');
        });

        //Add columns
        Schema::table('student_payment_done', function (Blueprint $table) {
            $table->foreignId('method_id')->references('id')->on('student_payment_methods');
            $table->decimal('amount_paid');
            $table->decimal('amount_due')->nullable();
            $table->date('due_date')->nullable();
            $table->longText('voucher')->nullable();
            $table->date('voucher_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
