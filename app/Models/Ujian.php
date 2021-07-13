<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Ujian extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_ujian'; // or null

    public $incrementing = false;
    // use SoftDeletes;
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
    protected $hidden = ['api_token','created_at','updated_at'];
}
