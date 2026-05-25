<?php

namespace Tests\Feature;

use App\Jobs\SendNotificationJob;
use App\Models\Mobil;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class MobilCrudTest extends TestCase
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
        $user = User::factory()->create(['api_token' => 'test-token-abc123']);

        return ['Authorization' => "Bearer {$user->api_token}"];
    }

    // -------------------------------------------------------------------------
    // GET /api/mobils — Daftar mobil (publik)
    // -------------------------------------------------------------------------

    public function test_index_returns_all_mobils(): void
    {
        Mobil::factory()->count(3)->create();

        $response = $this->getJson('/api/mobils');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => [
                    '*' => ['id', 'nama_mobil', 'merk', 'tahun', 'harga'],
                ],
            ])
            ->assertJsonCount(3, 'data');
    }

    public function test_index_returns_empty_array_when_no_mobils(): void
    {
        $response = $this->getJson('/api/mobils');

        $response->assertStatus(200)
            ->assertJson(['data' => []]);
    }

    // -------------------------------------------------------------------------
    // POST /api/mobils — Tambah mobil (terproteksi)
    // -------------------------------------------------------------------------

    public function test_store_creates_mobil_and_dispatches_job(): void
    {
        Queue::fake();

        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Alphard',
            'merk'       => 'Toyota',
            'tahun'      => 2024,
            'harga'      => 1_200_000_000,
        ], $this->authHeader());

        $response->assertStatus(201)
            ->assertJson([
                'success' => true,
                'data'    => [
                    'nama_mobil' => 'Alphard',
                    'merk'       => 'Toyota',
                    'tahun'      => 2024,
                ],
            ]);

        $this->assertDatabaseHas('mobils', ['nama_mobil' => 'Alphard', 'merk' => 'Toyota']);
        Queue::assertPushed(SendNotificationJob::class);
    }

    public function test_store_requires_authentication(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Alphard',
            'merk'       => 'Toyota',
            'tahun'      => 2024,
            'harga'      => 1_200_000_000,
        ]);

        $response->assertStatus(401);
    }

    public function test_store_rejects_invalid_token(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Alphard',
            'merk'       => 'Toyota',
            'tahun'      => 2024,
            'harga'      => 1_200_000_000,
        ], ['Authorization' => 'Bearer invalid-fake-token']);

        $response->assertStatus(401);
    }

    public function test_store_validates_required_fields(): void
    {
        $response = $this->postJson('/api/mobils', [], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['nama_mobil', 'merk', 'tahun', 'harga']);
    }

    public function test_store_validates_tahun_range(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Alphard',
            'merk'       => 'Toyota',
            'tahun'      => 1800,
            'harga'      => 1_200_000_000,
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tahun']);
    }

    public function test_store_validates_harga_is_non_negative(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Alphard',
            'merk'       => 'Toyota',
            'tahun'      => 2024,
            'harga'      => -500,
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['harga']);
    }

    // -------------------------------------------------------------------------
    // GET /api/mobils/{id} — Detail mobil (terproteksi)
    // -------------------------------------------------------------------------

    public function test_show_returns_mobil_detail(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->getJson("/api/mobils/{$mobil->id}", $this->authHeader());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['id' => $mobil->id],
            ]);
    }

    public function test_show_returns_404_for_nonexistent_mobil(): void
    {
        $response = $this->getJson('/api/mobils/9999', $this->authHeader());

        $response->assertStatus(404);
    }

    public function test_show_requires_authentication(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->getJson("/api/mobils/{$mobil->id}");

        $response->assertStatus(401);
    }

    // -------------------------------------------------------------------------
    // PUT /api/mobils/{id} — Update mobil (terproteksi)
    // -------------------------------------------------------------------------

    public function test_update_modifies_mobil(): void
    {
        $mobil = Mobil::factory()->create(['nama_mobil' => 'Old Name']);

        $response = $this->putJson("/api/mobils/{$mobil->id}", [
            'nama_mobil' => 'New Name',
        ], $this->authHeader());

        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'data'    => ['nama_mobil' => 'New Name'],
            ]);

        $this->assertDatabaseHas('mobils', ['id' => $mobil->id, 'nama_mobil' => 'New Name']);
    }

    public function test_update_requires_authentication(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->putJson("/api/mobils/{$mobil->id}", ['nama_mobil' => 'Test']);

        $response->assertStatus(401);
    }

    public function test_update_validates_fields(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->putJson("/api/mobils/{$mobil->id}", [
            'tahun' => 'bukan-angka',
        ], $this->authHeader());

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['tahun']);
    }

    // -------------------------------------------------------------------------
    // DELETE /api/mobils/{id} — Hapus mobil (terproteksi)
    // -------------------------------------------------------------------------

    public function test_destroy_deletes_mobil(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->deleteJson("/api/mobils/{$mobil->id}", [], $this->authHeader());

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseMissing('mobils', ['id' => $mobil->id]);
    }

    public function test_destroy_requires_authentication(): void
    {
        $mobil = Mobil::factory()->create();

        $response = $this->deleteJson("/api/mobils/{$mobil->id}");

        $response->assertStatus(401);
    }

    public function test_destroy_returns_404_for_nonexistent_mobil(): void
    {
        $response = $this->deleteJson('/api/mobils/9999', [], $this->authHeader());

        $response->assertStatus(404);
    }
}
