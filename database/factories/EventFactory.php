<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $venues = [
            'JIExpo Kemayoran, Jakarta',
            'BSD Grand Boulevard, Tangerang',
            'Senayan Park, Jakarta',
            'Bali International Convention Centre',
            'Trans Studio Mall, Bandung',
        ];

        return [
            'nama_event'    => fake()->words(3, true) . ' Auto Show',
            'tanggal_event' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d H:i:s'),
            'lokasi'        => fake()->randomElement($venues),
            'kapasitas'     => fake()->numberBetween(50, 1000),
        ];
    }
}
