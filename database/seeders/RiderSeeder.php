<?php

namespace Database\Seeders;

use App\Models\Area;
use App\Models\Document;
use App\Models\Experience;
use App\Models\RiderProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RiderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = Area::pluck('id')->toArray();
        if (empty($areas)) {
            $areas = [1]; // Fallback
        }

        $riderData = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi@rider.com',
                'application_status' => 'submitted',
                'description' => 'Pendaftar baru yang baru saja submit data.',
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@rider.com',
                'application_status' => 'document_verification',
                'description' => 'Sedang dalam tahap verifikasi berkas oleh admin.',
            ],
            [
                'name' => 'Agus Prayitno',
                'email' => 'agus@rider.com',
                'application_status' => 'interview',
                'interview_message' => 'Interview Senin jam 10 pagi di Kantor Tumbas Manahan.',
                'description' => 'Sudah lolos berkas dan dijadwalkan wawancara.',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@rider.com',
                'application_status' => 'final_approval',
                'description' => 'Tahap akhir persetujuan manajemen.',
            ],
            [
                'name' => 'Randi Kurniawan',
                'email' => 'randi@rider.com',
                'application_status' => 'accepted',
                'contract_days' => 30, // Contract ends in 30 days
                'description' => 'Rider Aktif saat ini.',
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@rider.com',
                'application_status' => 'accepted',
                'contract_days' => -5, // Contract ended 5 days ago (ALUMNI)
                'description' => 'Rider Alumni (kontrak sudah habis).',
            ],
        ];

        foreach ($riderData as $data) {
            // 1. Create User
            $user = User::create([
                'email' => $data['email'],
                'password' => Hash::make('password'),
                'role' => 'rider',
            ]);

            // 2. Create Rider Profile
            $profile = RiderProfile::create([
                'user_id' => $user->id,
                'full_name' => $data['name'],
                'phone_number' => '+62857' . rand(11111111, 99999999),
                'birth_date' => now()->subYears(rand(20, 35)),
                'gender' => rand(0, 1) ? 'male' : 'female',
                'address' => 'Jl. ' . $data['name'] . ' No. ' . rand(1, 100) . ', Jebres, Solo',
                'selected_area_id' => $areas[array_rand($areas)],
                'application_status' => $data['application_status'],
                'interview_message' => $data['interview_message'] ?? null,
                'contract_start_date' => ($data['application_status'] === 'accepted') ? now()->subMonths(1) : null,
                'contract_end_date' => isset($data['contract_days']) ? now()->addDays($data['contract_days']) : null,
            ]);

            // 3. Create Dummy Experience
            Experience::create([
                'rider_profile_id' => $profile->id,
                'company_name' => 'Kurir ' . rand(1, 10),
                'job_description' => 'Mengantar barang dan mengelola inventaris harian.',
                'start_date' => now()->subYears(2),
                'end_date' => now()->subYears(1),
            ]);

            // 4. Create Dummy Document (Path dummy)
            Document::create([
                'rider_profile_id' => $profile->id,
                'cv_path' => 'documents/cv/dummy-cv.pdf',
                'photo_path' => 'documents/photo/dummy-photo.jpg',
            ]);
        }
    }
}
