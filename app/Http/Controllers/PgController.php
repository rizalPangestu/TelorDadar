<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PG;
use Validator;
use Illuminate\Support\Facades\DB;
class PgController extends Controller
{
    //

    public function getSoalPG(Request $request){
        $soalPG = PG::get();

        return response()->json([
            'status'=>200,
            'message'=>"succes",
            'data'=>$soalPG
        ]);
    }

    public function addSoalPG(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();

        $validator = Validator::make($request->all(),[ 
            'soal_gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pil_a' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pil_b' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pil_c' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pil_d' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'gambar_pil_e' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]); 

        if($validator->fails()) {          
            return response()->json(['error'=>$validator->errors()], 401);                        
        }

        if($request->file('soal_gambar') ==  null){
            $image_soal = null;
        }else{
            $image_soal = $request->file('soal_gambar')->store('public/images/soalPg');
        }
        // if($request->file('gambar_pil_a') ==  null){
        //     $image_pilA = null;
        // }else{
        //     $image_pilA = $request->file('gambar_pil_a')->store('public/images/jawabanPG');
        // }

        // if($request->file('gambar_pil_b') ==  null){
        //     $image_pilB = null;
        // }else{
        //     $image_pilB = $request->file('gambar_pil_b')->store('public/images/jawabanPG');
        // }

        // if($request->file('gambar_pil_c') ==  null){
        //     $image_pilC = null;
        // }else{
        //     $image_pilC = $request->file('gambar_pil_c')->store('public/images/jawabanPG');
        // }
        // if($request->file('gambar_pil_d') ==  null){
        //     $image_pilD = null;
        // }else{
        //     $image_pilD = $request->file('gambar_pil_d')->store('public/images/jawabanPG');
        // }
        // if($request->file('gambar_pil_e') ==  null){
        //     $image_pilE = null;
        // }else{
        //     $image_pilE = $request->file('gambar_pil_e')->store('public/images/jawabanPG');
        // }
            
        if($request->file('gambar_pil_a') ==  null || $request->file('gambar_pil_b') ==  null || $request->file('gambar_pil_c') ==  null || $request->file('gambar_pil_d') ==  null || $request->file('gambar_pil_e') ==  null ){
            return response()->json([
                'status' => 404,
                'message' => 'pilihan gambar harus di isi semua'
            ],404);
            $image_pilA = null;
            $image_pilB = null;
            $image_pilC = null;
            $image_pilD = null;
            $image_pilE = null;
        }else{
            $image_pilA = $request->file('gambar_pil_a')->store('public/images/jawabanPG');
            $image_pilA = $request->file('gambar_pil_b')->store('public/images/jawabanPG');
            $image_pilA = $request->file('gambar_pil_c')->store('public/images/jawabanPG');
            $image_pilA = $request->file('gambar_pil_d')->store('public/images/jawabanPG');
            $image_pilA = $request->file('gambar_pil_e')->store('public/images/jawabanPG');
        }

        $addSoalPG = new PG;
        $addSoalPG -> id_dosen = $id_dosen->id_dosen;
        $addSoalPG -> id_matkul = $request -> input('id_matkul');
        $addSoalPG -> soal_pg = $request -> input('soal_pg');
        $addSoalPG -> pil_a = $request -> input('pil_a');
        $addSoalPG -> pil_b = $request -> input('pil_b');
        $addSoalPG -> pil_c = $request -> input('pil_c');
        $addSoalPG -> pil_d = $request -> input('pil_d');
        $addSoalPG -> pil_e = $request -> input('pil_e');
        $addSoalPG -> kunci_pg = $request -> input('kunci_pg');
        
        //input gambar
        $addSoalPG -> soal_gambar = $image_soal;
        $addSoalPG -> gambar_pil_a = $image_pilA;
        $addSoalPG -> gambar_pil_b = $image_pilB;
        $addSoalPG -> gambar_pil_c = $image_pilC;
        $addSoalPG -> gambar_pil_d = $image_pilD;
        $addSoalPG -> gambar_pil_e = $image_pilE;

        $addSoalPG->save();
        return response()->json([
            'status' => 200,
            'message' => 'berhasil',
            'data' => $addSoalPG,
        ]);
        
    }

    public function getSoalByDosen(Request $request){

        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();

        $listSoalbyDosen = PG::where('id_dosen', $id_dosen->id_dosen)->get();

        return response()->json([
            'status' => 200,
            'message' => 'get success',
            'data' => $listSoalbyDosen
        ],200);
    }
}
