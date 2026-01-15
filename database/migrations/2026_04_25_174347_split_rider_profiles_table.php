<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // 1. Create rider_educations table
        Schema::create('rider_educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_profile_id')->constrained('rider_profiles')->onDelete('cascade');
            $table->string('level')->nullable();
            $table->string('institution')->nullable();
            $table->year('graduation_year')->nullable();
            $table->timestamps();
        });

        // 2. Create rider_contracts table
        Schema::create('rider_contracts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rider_profile_id')->constrained('rider_profiles')->onDelete('cascade');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('status')->nullable(); // employment_status
            $table->timestamps();
        });

        // 3. Migrate existing data
        $profiles = DB::table('rider_profiles')->get();

        foreach ($profiles as $profile) {
            // Move education data
            if ($profile->education_level || $profile->education_institution || $profile->graduation_year) {
                DB::table('rider_educations')->insert([
                    'rider_profile_id' => $profile->id,
                    'level' => $profile->education_level,
                    'institution' => $profile->education_institution,
                    'graduation_year' => $profile->graduation_year,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Move contract data
            if ($profile->contract_start_date || $profile->contract_end_date || $profile->employment_status) {
                DB::table('rider_contracts')->insert([
                    'rider_profile_id' => $profile->id,
                    'start_date' => $profile->contract_start_date,
                    'end_date' => $profile->contract_end_date,
                    'status' => $profile->employment_status,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // 4. Drop columns from rider_profiles
        Schema::table('rider_profiles', function (Blueprint $table) {
            $table->dropColumn([
                'education_level',
                'education_institution',
                'graduation_year',
                'contract_start_date',
                'contract_end_date',
                'employment_status'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // 1. Add columns back to rider_profiles
        Schema::table('rider_profiles', function (Blueprint $table) {
            $table->string('education_level')->nullable();
            $table->string('education_institution')->nullable();
            $table->year('graduation_year')->nullable();
            $table->date('contract_start_date')->nullable();
            $table->date('contract_end_date')->nullable();
            $table->string('employment_status')->nullable();
        });

        // 2. Rollback data (optional but good practice)
        $educations = DB::table('rider_educations')->get();
        foreach ($educations as $edu) {
            DB::table('rider_profiles')->where('id', $edu->rider_profile_id)->update([
                'education_level' => $edu->level,
                'education_institution' => $edu->institution,
                'graduation_year' => $edu->graduation_year,
            ]);
        }

        $contracts = DB::table('rider_contracts')->get();
        foreach ($contracts as $con) {
            DB::table('rider_profiles')->where('id', $con->rider_profile_id)->update([
                'contract_start_date' => $con->start_date,
                'contract_end_date' => $con->end_date,
                'employment_status' => $con->status,
            ]);
        }

        // 3. Drop new tables
        Schema::dropIfExists('rider_contracts');
        Schema::dropIfExists('rider_educations');
    }
};
