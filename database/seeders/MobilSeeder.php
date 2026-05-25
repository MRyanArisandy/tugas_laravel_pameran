<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Mobil;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Mobil::create([
            'nama_mobil' => 'Toyota Alphard',
            'merk' => 'Toyota',
            'tahun' => 2025,
            'harga' => 1500000000.00,
        ]);

        Mobil::create([
            'nama_mobil' => 'Honda Civic Type R',
            'merk' => 'Honda',
            'tahun' => 2024,
            'harga' => 1400000000.00,
        ]);

        Mobil::create([
            'nama_mobil' => 'Hyundai Ioniq 5',
            'merk' => 'Hyundai',
            'tahun' => 2024,
            'harga' => 850000000.00,
        ]);

        Mobil::create([
            'nama_mobil' => 'BMW M4 Coupe',
            'merk' => 'BMW',
            'tahun' => 2023,
            'harga' => 2500000000.00,
        ]);
    }
}
