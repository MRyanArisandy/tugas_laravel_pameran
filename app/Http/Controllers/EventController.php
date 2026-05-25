<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Models\Event;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;

// Fitur 2: Attribute Middleware via HasMiddleware interface
class EventController extends Controller implements HasMiddleware
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
        $events = Event::all();

        return response()->json([
            'success' => true,
            'message' => 'Daftar event pameran mobil',
            'data'    => $events,
        ]);
    }

    // Fitur 5: Form Request — validasi dipindah ke StoreEventRequest
    public function store(StoreEventRequest $request)
    {
        $event = Event::create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil ditambahkan!',
            'data'    => $event,
        ], 201);
    }

    public function show(Event $event)
    {
        return response()->json([
            'success' => true,
            'message' => 'Detail event pameran',
            'data'    => $event,
        ]);
    }

    // Fitur 5: Form Request — validasi dipindah ke UpdateEventRequest
    public function update(UpdateEventRequest $request, Event $event)
    {
        $event->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil diperbarui!',
            'data'    => $event->fresh(),
        ]);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json([
            'success' => true,
            'message' => 'Event berhasil dihapus!',
        ]);
    }
}
