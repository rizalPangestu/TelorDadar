<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hasil extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_ujian',
        'id_dosen',
        'id_matkul',
        'email',
        'nama_mhs',
        'point',
        'nilai_akhir',
    ];
    protected $hidden = ['created_at','updated_at'];
}
