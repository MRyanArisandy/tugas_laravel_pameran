<?php

use Illuminate\Support\Facades\Route;
use App\Models\Event;

Route::get('/', function () {
    $events = Event::orderBy('tanggal_event', 'asc')->get();
    return view('welcome', compact('events'));
});
