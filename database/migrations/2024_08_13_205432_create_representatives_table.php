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
        Schema::create('representatives', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('last_name');
            $table->string('id_card');
            $table->string('whatsapp_number');
            $table->string('another_number');
            $table->string('occupation');
            $table->string('address');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->boolean('active')->default(true);
            $table->foreignId('student_id')->references('id')->on('students');
            $table->foreignId('how_found_us_id')->references('id')->on('how_found_us');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('representative');
    }
};
