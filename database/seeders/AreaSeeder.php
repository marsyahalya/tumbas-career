<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    public function run(): void
    {
        $areas = [
            [
                'name'         => 'Solo Safari',
                'description'  => 'Kawasan wisata Solo Safari, ramai pengunjung keluarga dan wisatawan.',
                'is_active'    => true,
            ],
            [
                'name'         => 'Keraton Surakarta',
                'description'  => 'Kawasan Keraton Surakarta, pusat wisata budaya dan kuliner tradisional.',
                'is_active'    => true,
            ],
            [
                'name'         => 'Masjid Raya Sheikh Zayed',
                'description'  => 'Kawasan Masjid Raya Sheikh Zayed, area ikonik baru kota Solo.',
                'is_active'    => true,
            ],
            [
                'name'         => 'Pasar Kewer',
                'description'  => 'Kawasan Pasar Kewer, ramai aktivitas perdagangan dan kuliner.',
                'is_active'    => true,
            ],
        ];

        foreach ($areas as $area) {
            Area::updateOrCreate(
                ['name' => $area['name']],
                $area
            );
        }

        $this->command->info('Area seeder berhasil: 4 lokasi Solo ditambahkan.');
    }
}
