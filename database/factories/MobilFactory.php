<?php

namespace Database\Factories;

use App\Models\Mobil;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mobil>
 */
class MobilFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $merks = ['Toyota', 'Honda', 'BMW', 'Mercedes-Benz', 'Audi', 'Lexus', 'Nissan', 'Hyundai'];
        $namaModels = ['Alphard', 'Fortuner', 'Civic', 'CR-V', 'X5', 'GLE', 'A4', 'RX 350', 'GT-R', 'Tucson'];

        return [
            'nama_mobil' => fake()->randomElement($namaModels),
            'merk'       => fake()->randomElement($merks),
            'tahun'      => fake()->numberBetween(2018, 2026),
            'harga'      => fake()->randomFloat(2, 200_000_000, 3_000_000_000),
        ];
    }
}
