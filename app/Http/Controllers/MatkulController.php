<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Matkul;
class MatkulController extends Controller
{
    //
    public function getMatkul(){
        $matkul = DB::table('matkuls')->get();

        return response()->json(
            [
                'message' => 'Get data succes',
                'status' => 200,
                'data' => $matkul
            ]
            );
    }

    public function addMatkul(Request $request){
        $addMatkul = new Matkul;
        $addMatkul -> nama_matkul = $request->input('nama_matkul');
        $addMatkul -> id_dosen = $request->input('id_dosen');
        $addMatkul -> kelas = $request->input('kelas');
        $addMatkul -> prodi = $request->input('prodi');

        $addMatkul ->save();

        return response()->json(
            [
                'message' => 'Berhasil Di tambah',
                'status' => 200,
                'data' => $addMatkul
            ]
            );
    }


    public function getMatkulbyDosen(Request $request){

        $token = explode(' ', $request->header('Authorization'));

        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        $matkulByDosen = Matkul::where('id_dosen','=',$id_dosen->id_dosen)->get();

        return response() -> json(
            [
                'status' =>200,
                'message' => 'Data Berhasil Di Get',
                'data' => $matkulByDosen
            ],200
        );


    }
}
