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
        Schema::create('student_payment_done_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('method_id')->references('id')->on('student_payment_methods');
            $table->decimal('amount_paid');
            $table->date('due_date')->nullable();
            $table->longText('voucher')->nullable();
            $table->date('voucher_date')->nullable();
            $table->string('reference');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('active')->default(true);
            $table->foreignId('student_payment_done_id')->references('id')->on('student_payment_done');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_payment_done_items');
    }
};
