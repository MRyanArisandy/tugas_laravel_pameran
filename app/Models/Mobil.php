<?php

namespace App\Models;

use Database\Factories\MobilFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mobil extends Model
{
    /** @use HasFactory<MobilFactory> */
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nama_mobil',
        'merk',
        'tahun',
        'harga',
    ];
}
