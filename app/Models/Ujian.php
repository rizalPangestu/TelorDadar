<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_dosen',
        'id_matkul',
        'kode_soal',
        'pass_soal',
        'nama_ujian',
        'waktu_ujian',
        'mulai',
        'selesai',
        'api_token'
    ];
    protected $hidden = ['created_at','updated_at'];
}
