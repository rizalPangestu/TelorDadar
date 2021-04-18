<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Soal extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dosen',
        'id_matkul',
        'soal_essay',
        'kunci_essay',
        'gambar',
    ];

    protected $table = 'essays';
}
