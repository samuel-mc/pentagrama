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
            //drop the fk
            $table->dropForeign('student_payment_done_student_payment_types_id_foreign');
            //drop the column   
            $table->dropColumn('student_payment_types_id');
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
