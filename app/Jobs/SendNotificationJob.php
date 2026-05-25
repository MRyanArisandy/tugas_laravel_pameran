<?php

namespace App\Jobs;

use App\Models\Mobil;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Throwable;

class SendNotificationJob implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Jumlah maksimal percobaan job ini.
     */
    public int $tries = 3;

    /**
     * Create a new job instance.
     */
    public function __construct(public Mobil $mobil)
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
        // Simulasi proses berat (misalnya pengiriman notifikasi email/push)
        sleep(2);

        Log::info("Notifikasi Pameran: Mobil baru '{$this->mobil->nama_mobil}' ({$this->mobil->merk}) telah ditambahkan ke pameran pada " . now()->toDateTimeString());
    }

    /**
     * Tangani ketika job gagal permanen setelah semua percobaan habis.
     */
    public function failed(Throwable $exception): void
    {
        Log::error("SendNotificationJob GAGAL untuk mobil ID {$this->mobil->id} ({$this->mobil->nama_mobil}): {$exception->getMessage()}");
    }
}