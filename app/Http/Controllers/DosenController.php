<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function getData(){
        $dosen = DB::table('dosen')->get();
        return response()->json(
            [
                "message" => 'get Data sucess',
                "data" => $dosen
            ]
            );
    }
}
