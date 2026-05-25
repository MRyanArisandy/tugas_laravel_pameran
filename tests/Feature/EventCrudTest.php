<?php

namespace Tests\Feature;

use App\Models\Event;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Tests\TestCase;

class EventCrudTest extends TestCase
{
    use LazilyRefreshDatabase;

    // -------------------------------------------------------------------------
    // Helpers
    // -------------------------------------------------------------------------

    /**
     * Create an authenticated user and return the Authorization header.
     *
     * @return array<string, string>
     */
    private function authHeader(): array
    {
        $user = User::factory()->create(['api_token' => 'event-test-token-xyz']);

        return ['Authorization' => "Bearer {$user->api_token}"];
    }

    // -------------------------------------------------------------------------
    // GET /api/events — Daftar event (publik)
    // -------------------------------------------------------------------------

    public function test_index_returns_all_events(): void
    {
        Event::factory()->count(3)->create();

        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => ['id', 'nama_event', 'tanggal_event', 'lokasi', 'kapasitas'],
                ],
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_index_returns_empty_array_when_no_events(): void
    {
        $response = $this->getJson('/api/events');

        $response->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    // -------------------------------------------------------------------------
    // POST /api/events — Tambah event (terproteksi)
    // -------------------------------------------------------------------------

    public function test_store_creates_event(): void
    {
        $response = $this->postJson('/api/events', [
            'nama_event'    => 'JIMS 2026',
            'tanggal_event' => '2026-07-15 10:00:00',
            'lokasi'        => 'JIExpo Kemayoran, Jakarta',
            'kapasitas'     => 500,
        ], $this->authHeader());

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'nama_event' => 'JIMS 2026',
                    'kapasitas'  => 500,
                ],
            ]);

        $this->assertDatabaseHas('events', ['nama_event' => 'JIMS 2026']);
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/events', [
            'nama_event'    => 'JIMS 2026',
            'tanggal_event' => '2026-07-15 10:00:00',
            'lokasi'        => 'JIExpo Kemayoran, Jakarta',
            'kapasitas'     => 500,
        ]);

        $response->assertStatus(401);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/events', [], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nama_event', 'tanggal_event', 'lokasi', 'kapasitas']);
    }

    public function test_store_validates_kapasitas_is_positive(): void
    {
        $response = $this->postJson('/api/events', [
            'nama_event'    => 'JIMS 2026',
            'tanggal_event' => '2026-07-15 10:00:00',
            'lokasi'        => 'Jakarta',
            'kapasitas'     => 0,
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kapasitas']);
    }

    public function test_store_validates_tanggal_event_is_a_date(): void
    {
        $response = $this->postJson('/api/events', [
            'nama_event'    => 'JIMS 2026',
            'tanggal_event' => 'bukan-tanggal',
            'lokasi'        => 'Jakarta',
            'kapasitas'     => 100,
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tanggal_event']);
    }

    // -------------------------------------------------------------------------
    // GET /api/events/{id} — Detail event (terproteksi)
    // -------------------------------------------------------------------------

    public function test_show_returns_event_detail(): void
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/events/{$event->id}", $this->authHeader());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['id' => $event->id],
            ]);
    }

    public function test_show_returns_404_for_nonexistent_event(): void
    {
        $response = $this->getJson('/api/events/9999', $this->authHeader());

        $response->assertStatus(404);
    }

    public function test_show_requires_authentication(): void
    {
        $event = Event::factory()->create();

        $response = $this->getJson("/api/events/{$event->id}");

        $response->assertStatus(401);
    }

    // -------------------------------------------------------------------------
    // PUT /api/events/{id} — Update event (terproteksi)
    // -------------------------------------------------------------------------

    public function test_update_modifies_event(): void
    {
        $event = Event::factory()->create(['nama_event' => 'Old Event Name']);

        $response = $this->putJson("/api/events/{$event->id}", [
            'nama_event' => 'Updated Event Name',
        ], $this->authHeader());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['nama_event' => 'Updated Event Name'],
            ]);

        $this->assertDatabaseHas('events', ['id' => $event->id, 'nama_event' => 'Updated Event Name']);
    }

    public function test_update_requires_authentication(): void
    {
        $event = Event::factory()->create();

        $response = $this->putJson("/api/events/{$event->id}", ['nama_event' => 'Test']);

        $response->assertStatus(401);
    }

    public function test_update_validates_kapasitas_when_provided(): void
    {
        $event = Event::factory()->create();

        $response = $this->putJson("/api/events/{$event->id}", [
            'kapasitas' => -10,
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['kapasitas']);
    }

    // -------------------------------------------------------------------------
    // DELETE /api/events/{id} — Hapus event (terproteksi)
    // -------------------------------------------------------------------------

    public function test_destroy_deletes_event(): void
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}", [], $this->authHeader());

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('events', ['id' => $event->id]);
    }

    public function test_destroy_requires_authentication(): void
    {
        $event = Event::factory()->create();

        $response = $this->deleteJson("/api/events/{$event->id}");

        $response->assertStatus(401);
    }

    public function test_destroy_returns_404_for_nonexistent_event(): void
    {
        $response = $this->deleteJson('/api/events/9999', [], $this->authHeader());

        $response->assertStatus(404);
    }
}
