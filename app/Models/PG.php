<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PG extends Model
{
    use HasFactory;

    protected $table ="t_pg";
    protected $primaryKey = 'id_soalPG';
    protected $fillable = [
        'id_dosen',
        'id_matkul',
    ];

}
