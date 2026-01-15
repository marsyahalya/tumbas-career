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
                'application_status' => 'submit',
                'employment_status' => null,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti@rider.com',
                'application_status' => 'verifikasi_berkas',
                'employment_status' => 'terima', // Berkas diterima
            ],
            [
                'name' => 'Agus Prayitno',
                'email' => 'agus@rider.com',
                'application_status' => 'wawancara',
                'employment_status' => null,
                'interview_message' => 'Wawancara besok jam 09:00 di Tumbas Office.',
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi@rider.com',
                'application_status' => 'final_approval',
                'employment_status' => 'terima', // Lolos wawancara
            ],
            [
                'name' => 'Randi Kurniawan',
                'email' => 'randi@rider.com',
                'application_status' => 'final_approval',
                'employment_status' => 'terima',
                'contract_days' => 30, // Aktif
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko@rider.com',
                'application_status' => 'final_approval',
                'employment_status' => 'terima',
                'contract_days' => -5, // Alumni
            ],
            [
                'name' => 'Gatot Kaca',
                'email' => 'gatot@rider.com',
                'application_status' => 'verifikasi_berkas',
                'employment_status' => 'ditolak', // Berkas ditolak
            ],
            [
                'name' => 'Marsya Halya',
                'email' => 'marsya@rider.com',
                'application_status' => 'submit',
                'employment_status' => null,
            ],
            [
                'name' => 'Bambang Pamungkas',
                'email' => 'bambang@rider.com',
                'application_status' => 'wawancara',
                'employment_status' => null,
            ],
            [
                'name' => 'Indah Permata',
                'email' => 'indah@rider.com',
                'application_status' => 'final_approval',
                'employment_status' => 'terima',
                'contract_days' => 60,
            ],
            [
                'name' => 'Dinda Kirana',
                'email' => 'dinda@rider.com',
                'application_status' => 'final_approval',
                'employment_status' => 'ditolak', // Gagal seleksi akhir
            ],
        ];

        foreach ($riderData as $data) {
            // 1. Create User
            $user = User::create([
                'name'  => $data['name'],
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
                'city' => 'Surakarta',
                'address' => 'Jl. ' . $data['name'] . ' No. ' . rand(1, 100) . ', Jebres, Solo',
                'selected_area_id' => $areas[array_rand($areas)],
                'education_level' => ['SMA', 'D3', 'S1'][rand(0, 2)],
                'education_institution' => 'Universitas ' . $data['name'],
                'graduation_year' => rand(2015, 2023),
                'application_status' => $data['application_status'],
                'employment_status' => $data['employment_status'] ?? null,
                'interview_message' => $data['interview_message'] ?? null,
                'contract_start_date' => (isset($data['contract_days'])) ? now()->subMonths(1) : null,
                'contract_end_date' => isset($data['contract_days']) ? now()->addDays($data['contract_days']) : null,
            ]);

            // 3. Create Dummy Experience
            Experience::create([
                'rider_profile_id' => $profile->id,
                'company_name' => 'Layanan Antar ' . rand(1, 10),
                'position' => 'Rider Kurir (Dummy Exp)',
                'start_date' => now()->subYears(2),
                'end_date' => now()->subYears(1),
            ]);

            // 4. Create Dummy Document
            Document::create([
                'rider_profile_id' => $profile->id,
                'cv_path' => 'documents/cv/dummy-cv.pdf',
                'photo_path' => 'documents/photo/dummy-photo.jpg',
            ]);
        }
    }
}
