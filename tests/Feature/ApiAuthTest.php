<?php

namespace Tests\Feature;

use App\Jobs\LogApiAuthenticationJob;
use App\Models\User;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class ApiAuthTest extends TestCase
{
    use LazilyRefreshDatabase;

    // -------------------------------------------------------------------------
    // POST /api/login
    // -------------------------------------------------------------------------

    public function test_login_succeeds_with_valid_credentials(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'token',
                'user' => ['name', 'email'],
            ])
            ->assertJson(['success' => true]);

        // Token should be generated and stored
        $user->refresh();
        $this->assertNotNull($user->api_token);
    }

    public function test_login_dispatches_log_job_on_success(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $this->postJson('/api/login', [
            'email'    => 'admin@example.com',
            'password' => 'secret123',
        ]);

        Queue::assertPushed(LogApiAuthenticationJob::class, function (LogApiAuthenticationJob $job) use ($user) {
            return $job->user->id === $user->id;
        });
    }

    public function test_login_reuses_existing_token(): void
    {
        Queue::fake();

        $user = User::factory()->create([
            'email'     => 'admin@example.com',
            'password'  => bcrypt('secret123'),
            'api_token' => 'existing-token-xyz',
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'admin@example.com',
            'password' => 'secret123',
        ]);

        $response->assertStatus(200)
            ->assertJson(['token' => 'existing-token-xyz']);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        User::factory()->create([
            'email'    => 'admin@example.com',
            'password' => bcrypt('secret123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email'    => 'admin@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_login_fails_with_nonexistent_email(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'nobody@example.com',
            'password' => 'password',
        ]);

        $response->assertStatus(401);
    }

    public function test_login_validates_required_fields(): void
    {
        $response = $this->postJson('/api/login', []);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email', 'password']);
    }

    public function test_login_validates_email_format(): void
    {
        $response = $this->postJson('/api/login', [
            'email'    => 'not-an-email',
            'password' => 'password',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    // -------------------------------------------------------------------------
    // POST /api/logout (terproteksi)
    // -------------------------------------------------------------------------

    public function test_logout_succeeds_with_valid_token(): void
    {
        $user = User::factory()->create(['api_token' => 'logout-test-token']);

        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer logout-test-token',
        ]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);
    }

    public function test_logout_fails_without_token(): void
    {
        $response = $this->postJson('/api/logout');

        $response->assertStatus(401);
    }

    public function test_logout_fails_with_invalid_token(): void
    {
        $response = $this->postJson('/api/logout', [], [
            'Authorization' => 'Bearer this-token-does-not-exist',
        ]);

        $response->assertStatus(401);
    }

    // -------------------------------------------------------------------------
    // Middleware: api.auth
    // -------------------------------------------------------------------------

    public function test_middleware_rejects_missing_authorization_header(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Test',
            'merk'       => 'Test',
            'tahun'      => 2024,
            'harga'      => 100,
        ]);

        $response->assertStatus(401)
            ->assertJson(['success' => false]);
    }

    public function test_middleware_rejects_malformed_bearer_token(): void
    {
        $response = $this->postJson('/api/mobils', [
            'nama_mobil' => 'Test',
            'merk'       => 'Test',
            'tahun'      => 2024,
            'harga'      => 100,
        ], ['Authorization' => 'Token not-a-bearer']);

        $response->assertStatus(401);
    }
}
