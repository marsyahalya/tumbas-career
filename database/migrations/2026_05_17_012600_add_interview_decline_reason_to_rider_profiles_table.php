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
            $table->string('interview_decline_reason')->nullable();
            $table->date('interview_reschedule_date')->nullable();
            $table->text('interview_decline_details')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rider_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'interview_decline_reason',
                'interview_reschedule_date',
                'interview_decline_details'
            ]);
        });
    }
};
