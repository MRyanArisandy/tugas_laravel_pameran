<?php

namespace App\Models;

use Database\Factories\EventFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /** @use HasFactory<EventFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nama_event',
        'tanggal_event',
        'lokasi',
        'kapasitas',
    ];
}
