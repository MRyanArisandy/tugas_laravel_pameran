<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogApiAuthenticationJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Jumlah maksimal percobaan job ini.
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public User $user)
    {
        //
    }

    /**
     * Delay retry menggunakan exponential backoff: 1s, 5s, 10s.
     *
     * @return array<int, int>
     */
    public function backoff(): array
    {
        return [1, 5, 10];
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Simulasi proses latar belakang (misalnya audit log keamanan atau pengiriman email)
        sleep(2);

        Log::info("Audit Keamanan API: Pengguna {$this->user->name} ({$this->user->email}) berhasil diautentikasi ke sistem pada " . now()->toDateTimeString());
    }

    /**
     * Tangani ketika job gagal permanen setelah semua percobaan habis.
     */
    public function failed(Throwable $exception): void
    {
        Log::error("LogApiAuthenticationJob GAGAL untuk user ID {$this->user->id} ({$this->user->email}): {$exception->getMessage()}");
    }
}
