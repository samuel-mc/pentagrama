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

        Schema::table('groups', function (Blueprint $table) {
            if (Schema::hasColumn('groups', 'name')) {
                $table->dropColumn("name");
            }

            if (Schema::hasColumn('groups', 'age_id')) {
                $table->dropForeign("groups_age_id_foreign");
                $table->dropColumn("age_id");
            }
        });

        Schema::table('schedules', function (Blueprint $table) {
            if (Schema::hasColumn('schedules', 'end_hour')) {
                $table->dropColumn("end_hour");
            }
        });

        Schema::table('groups', function (Blueprint $table) {
            $table->foreignId('student_id')->nullable()->references('id')->on('students');
            if (!Schema::hasColumn('groups', 'monthly_payment')) {
                $table->double('monthly_payment')->default(0);
            }
            if (!Schema::hasColumn('groups', 'monthly_payment_date')) {
                $table->date('monthly_payment_date')->nullable();
            }
        });

        Schema::dropIfExists('students_groups');

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
