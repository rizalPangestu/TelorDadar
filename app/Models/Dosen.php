<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Dosen extends Model
{
    use HasFactory;
    
    protected $fillable = ['nidn','nama','prodi','password'];
    protected $primaryKey = 'id_dosen';
    protected $hidden = ['password', 'created_at',  "created_at","updated_at"];
    use SoftDeletes;
}
