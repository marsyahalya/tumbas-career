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
        Schema::table('rider_profiles', function (Blueprint $table) {
            $table->integer('interview_attendance_count')->default(0)->after('interview_sent_at');
            $table->timestamp('interview_attendance_updated_at')->nullable()->after('interview_attendance_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rider_profiles', function (Blueprint $table) {
            $table->dropColumn(['interview_attendance_count', 'interview_attendance_updated_at']);
        });
    }
};
