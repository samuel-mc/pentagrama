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
        Schema::create('request_student_payments', function (Blueprint $table) {
            $table->id();
            $table->double('amount_to_pay');
            $table->double('amount_paid')->nullable();
            $table->date('due_date')->nullable();
            $table->foreignId('student_id')->references('id')->on('students');
            $table->foreignId('group_id')->nullable()->references('id')->on('groups');
            $table->decimal('rate', 8, 2);
            $table->boolean('is_paid')->default(false);
            $table->foreignId('payment_type_id')->references('id')->on('student_payment_types');
            $table->foreignId('payment_method_id')->references('id')->on('student_payment_methods');
            $table->longText('voucher')->nullable();
            $table->date('voucher_date')->nullable();
            $table->string('reference');
            $table->boolean('accepted')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_student_payments');
    }
};
