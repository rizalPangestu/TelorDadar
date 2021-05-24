<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;
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
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        
        // $validatedData = $request->validate([
        //     'gambar' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
        // ]);
        $validator = Validator::make($request->all(),[ 
            'gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);  
    
        if($validator->fails()) {          
        
        return response()->json(['error'=>$validator->errors()], 401);                        
        } 
        
        if($request -> file('gambar') == null){
            $image = null;
        }else{
            $image = $request->file('gambar')->store('public/images');
        }

        $addSoalEssay = new Soal;
        $addSoalEssay -> id_dosen = $id_dosen->id_dosen;
        $addSoalEssay -> id_matkul = $request->input('id_matkul');
        $addSoalEssay -> soal_essay = $request->input('soal_essay');
        // $addSoalEssay -> gambar = $request->input('gambar');
        $addSoalEssay -> gambar = $image;
        $addSoalEssay -> kunci_essay = $request->input('kunci_essay');

        $addSoalEssay->save();
        return response()->json([
            'message' => 'soal berhasil di simpan',
            'data'=> $addSoalEssay,
                'images' => $image
        
        ]);
    }


    public function getSoalbyId(Request $request){

        $token = explode(' ', $request->header('Authorization'));

        $dataSoal = DB::table('ujians')
        ->select('id_dosen','id_matkul')
        ->where('ujians.api_token',$token[1])->first();
        
        $getSoalbyId = DB::table('essays')
        // ->join('dosens', 'essays.id_dosen', '=', 'dosens.id_dosen')
        // ->join('matkuls', 'essays.id_matkul', '=', 'matkuls.id_matkul')
        ->where('id_dosen', $dataSoal->id_dosen)
        ->where('id_matkul', $dataSoal->id_matkul)
        ->get();


        return response()-> json(
            [
                'message' => 'Sucess',
                'data' => $getSoalbyId,
            ]
            );
    }

}
