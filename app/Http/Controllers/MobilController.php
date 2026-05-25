<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMobilRequest;
use App\Http\Requests\UpdateMobilRequest;
use App\Jobs\SendNotificationJob;
use App\Models\Mobil;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Fitur 2: Attribute Middleware via HasMiddleware interface
class MobilController extends Controller implements HasMiddleware
{
    /**
     * Middleware yang diterapkan pada controller ini.
     * index bersifat publik; semua method lain wajib terautentikasi.
     *
     * @return array<int, Middleware>
     */
    public static function middleware(): array
    {
        return [
            new Middleware('api.auth', except: ['index']),
        ];
    }

    public function index()
    {
        $mobil = Mobil::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar mobil pameran',
            'data'    => $mobil,
        ]);
    }

    // Fitur 5: Form Request — validasi dipindah ke StoreMobilRequest
    public function store(StoreMobilRequest $request)
    {
        $mobil = Mobil::create($request->validated());

        // Dispatch Job ke antrean (Queue)
        SendNotificationJob::dispatch($mobil);

        return response()->json([
            'success' => true,
            'message' => 'Mobil berhasil ditambahkan dan notifikasi sedang dikirim!',
            'data'    => $mobil,
        ], 201);
    }

    public function show(Mobil $mobil)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail mobil pameran',
            'data'    => $mobil,
        ]);
    }

    // Fitur 5: Form Request — validasi dipindah ke UpdateMobilRequest
    public function update(UpdateMobilRequest $request, Mobil $mobil)
    {
        $mobil->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Data mobil berhasil diperbarui!',
            'data'    => $mobil->fresh(),
        ]);
    }

    public function destroy(Mobil $mobil)
    {
        $mobil->delete();

        return response()->json([
            'success' => true,
            'message' => 'Mobil berhasil dihapus dari pameran!',
        ]);
    }
}