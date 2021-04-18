<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;

class DosenController extends Controller
{
    public function getData(){
        $dosen = DB::table('dosens')->get();
        return response()->json(
            [
                "message" => 'get Data sucess',
                "data" => $dosen
            ]
            );
    }

    public function postData(Request $request){
			
			$dataDosen  = new Dosen;
			$dataDosen -> nidn = $request->input('nidn');
			$dataDosen -> nama_dosen = $request->input('nama_dosen');
			$dataDosen -> prodi = $request->input('prodi');

			$dataDosen -> save();
				return response() -> json(
					[
						'message' => 'Data Berhasil Di simpan',
						'data' => $dataDosen
					]
				);
		}
}
