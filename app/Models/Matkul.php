<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Matkul extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $primaryKey = 'id_matkul';
    protected $hidden = ['created_at','updated_at'];
}
