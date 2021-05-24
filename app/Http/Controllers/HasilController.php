<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;
use Illuminate\Support\Facades\DB;
class HasilController extends Controller
{
    //
    public function getHasilUjian(Request $request){
        $hasilUjian = DB::table('hasils')->get();

        return response()->json([
            'status' => 200,
            'message' => 'get sucess',
            'data' => $hasilUjian
        ]);
    }

    public function getHasilUjianbyDosen(Request $request, $id){
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        
        $hasilUjian = DB::table('hasils')->where('id_dosen',$id_dosen->id_dosen)->where('id_ujian',$id)->get();

        return response()->json([
            'status' => 200,
            'message' => 'get sucess',
            'data' => $hasilUjian
        ]);
    }

    public function postHasilUjian(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $ujian = DB::table('ujians')->select('id_ujian', 'id_dosen', 'id_matkul','jlm_soal')->where('api_token',$token[1])->first();
        
        $dataHasil  = new Hasil;
        $dataHasil -> id_ujian = $ujian->id_ujian;
        $dataHasil -> id_dosen = $ujian -> id_dosen;
        $dataHasil -> id_matkul= $ujian -> id_matkul;
        $dataHasil -> email = $request->input('email');
        $dataHasil -> nim = $request->input('nim');
        $dataHasil ->nama_mhs = $request->input('nama_mhs');
        $dataHasil ->point = $request->input('point');
        $dataHasil ->nilai_akhir = ($dataHasil->point / $ujian->jlm_soal ) * 100;

        $dataHasil -> save();
         return response()->json([
            'status' => 200,
            'message' => 'get sucess',
            'data' => $dataHasil
        ]);
    }
}
