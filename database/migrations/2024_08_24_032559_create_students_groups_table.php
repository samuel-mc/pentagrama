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
        Schema::create('students_groups', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_group')->references('id')->on('groups');
            $table->foreignId('id_student')->references('id')->on('students');
            $table->decimal('monthly_payment');
            $table->date('payment_date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('active')->default(true);
        });

        // Drop the column monthly_payment and payment_date from the table student_payments_data
        Schema::table('student_payments_data', function (Blueprint $table) {
            $table->dropColumn('monthly_payment');
            $table->dropColumn('payment_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students_groups');
    }
};
