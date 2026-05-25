<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Event;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Seed Users
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'api_token' => 'super-secret-api-token-12345',
        ]);

        // Seed Mobils
        $this->call(MobilSeeder::class);

        // Seed Events
        Event::create([
            'nama_event' => 'Jakarta International Motor Show (JIMS)',
            'tanggal_event' => now()->addDays(5)->format('Y-m-d H:i:s'),
            'lokasi' => 'JIExpo Kemayoran, Jakarta',
            'kapasitas' => 500,
        ]);

        Event::create([
            'nama_event' => 'Exotic Supercar Exhibition',
            'tanggal_event' => now()->addDays(12)->format('Y-m-d H:i:s'),
            'lokasi' => 'BSD Grand Boulevard, Tangerang',
            'kapasitas' => 150,
        ]);

        Event::create([
            'nama_event' => 'Electric Vehicle Showdown 2026',
            'tanggal_event' => now()->addDays(20)->format('Y-m-d H:i:s'),
            'lokasi' => 'Senayan Park, Jakarta',
            'kapasitas' => 300,
        ]);
    }
}
