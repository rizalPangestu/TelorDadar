<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;
class SoalController extends Controller
{
    //

    public function  getSoal(){
        $soalEssay = DB::table('essays')->get();
    
        return response()->json(
            [
                'message' => 'get data sucess',
                'data' => $soalEssay
            ],200
        );
    }

    public function addSoal(Request $request){
        // $addSoalEssay = DB::table('essays')->insert([
        //     'id_dosen' => $request->id_dosen,
        //     'id_matkul' => $request->id_matkul,
        //     'soal_essay' => $request->soal_essay,
        //     'gambar' => $request->gambar,
        //     'kunci_essay' => $request->kunci_essay
        // ]);
        
        // $addSoalEssay->save();
        $addSoalEssay = new Soal;
        $addSoalEssay -> id_dosen = $request->input('id_dosen');
        $addSoalEssay -> id_matkul = $request->input('id_matkul');
        $addSoalEssay -> soal_essay = $request->input('soal_essay');
        $addSoalEssay -> gambar = $request->input('gambar');
        $addSoalEssay -> kunci_essay = $request->input('kunci_essay');

        $addSoalEssay->save();
        return response()->json([
            'message' => 'soal berhasil di simpan',
            'data'=> $addSoalEssay
        ]);
    }


    public function getSoalbyId(Request $request){
        $getSoalbyId = DB::table('essays')
        // ->join('dosens', 'essays.id_dosen', '=', 'dosens.id_dosen')
        // ->join('matkuls', 'essays.id_matkul', '=', 'matkuls.id_matkul')
        ->where('id_dosen', $request->id_dosen)
        ->where('id_matkul', $request->id_matkul)
        ->get();


        return response()-> json(
            [
                'message' => 'Sucess',
                'data' => $getSoalbyId
            ]
            );
    }

}
