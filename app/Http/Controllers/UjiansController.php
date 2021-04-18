<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ujian;
use Auth;
use Illuminate\Support\Str;
class UjiansController extends Controller
{
    //
    
    public function getData(){
        $dataUjian  = DB::table('ujians')->get();

        return response()->json(
            [
                'message' => "Get Sucess",
                'data' => $dataUjian
            ]
        );
    }



    public function postData(Request $request){
        $dataUjian = new Ujian;
        $dataUjian -> id_dosen = $request -> input("id_dosen");
        $dataUjian -> id_matkul = $request -> input("id_matkul");
        $dataUjian -> kode_ujian = $request -> input("kode_ujian");
        $dataUjian -> pass_ujian = $request -> input("pass_ujian");
        $dataUjian -> nama_ujian = $request -> input("nama_ujian");
        $dataUjian -> waktu_ujian = $request -> input("waktu_ujian");
        $dataUjian -> mulai = $request -> input("mulai");
        $dataUjian -> selesai = $request -> input("selesai");
        $dataUjian -> api_token = Str::random(60);

        $dataUjian ->save();
        return response() -> json(
            [
                'message' => 'data di simpan',
                'data' => $dataUjian
            ]
            );

    }

    public function getUJianDetail(Request $request){
        // $ujian = DB::table('ujian')
        //         ->join('soalpills','ujian.id_ujian', '=','soalpills.id_soal' )
        //         ->join('essays','ujian.id_ujian', '=','essays.id_soalEssay' )
        //         ->select(
        //             'ujian.nama_dosen',
        //             'ujian.matkul',
        //             'ujian.mulai',
        //             'ujian.selesai',
        //             'soalpills.soal',
        //             'soalpills.pill_a',
        //             'soalpills.pill_b',
        //             'soalpills.pill_c',
        //             'soalpills.pill_d',
        //             'soalpills.pill_e',
        //             'essays.soal_essay'
        //             )->where('id_ujian',$id)
        //         ->get();

        // $header = 'cAdecicNohkzcavyjyPhyLFC2AYK5890u2liSPKxuhjn9zKmiqvJqNo0yqmS';
        $header = $request->bearerToken();
        $ujian = DB::table('ujians')
        ->select('id_ujian','nama_dosen','nama_matkul','nama_ujian','waktu_ujian','mulai','selesai')
        ->join('dosens','ujians.id_dosen', '=', 'dosens.id_dosen')
        ->join('matkuls','ujians.id_matkul', '=', 'matkuls.id_matkul')
        ->where('api_token','=',$header)->first();
        // $ujian = $id;
        // $soalUjianEssay = DB::table('essays')->get();
        // $soalUjianPG = DB::table('soalpills')->get();


        return response()->json(
            [
                'message' => "Get Sucess",
                'data' => $ujian
            ]
        );
    }

    public function loginUjian(Request $request){

        $dataLogin =  DB::table('ujians')
        ->select('id_ujian','api_token')
        // ->join('dosens','ujians.id_dosen', '=', 'dosens.id_dosen')
        // ->join('matkuls','ujians.id_matkul', '=', 'matkuls.id_matkul')
        ->where("kode_ujian", $request->kode_ujian)
        ->where("pass_ujian", $request->pass_ujian)
        ->first();    
        
        
        if($dataLogin === null){
            return response()->json(
                [
                    'message' => 'login gagal',
                    'data' => 'ujian tidak di temukan'
                ]
            );
        }else{
            return response()->json(
                [
                'message' => 'login success',
                'data' => $dataLogin
            ]
        );
        };
        // if(Auth::attempt(['kode_soal' => $request-> kode_soal, "pass_soal" => $request->pass_soal])){
        //     return response()->json([
        //         'error' => 'your Credential is Wrong',
        //         401
        //     ]);
        // }

        // $ujian  = $ujian->find(Auth::ujian()->id);

        // return fractal()
        // -> item($ujian);


    }
}
