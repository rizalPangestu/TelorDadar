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
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();

        $dataUjian = new Ujian;
        $dataUjian -> id_dosen =  $id_dosen->id_dosen;
        $dataUjian -> id_matkul = $request -> input("id_matkul");
        $dataUjian -> kode_ujian = strtoupper(Str::random(6));
        $dataUjian -> pass_ujian = $request -> input("pass_ujian");
        $dataUjian -> nama_ujian = $request -> input("nama_ujian");
        $dataUjian -> jlm_soal = $request -> input("jlm_soal");
        $dataUjian -> waktu_ujian = $request -> input("waktu_ujian");
        $dataUjian -> mulai = $request -> input("mulai");
        $dataUjian -> selesai = $request -> input("selesai");
        $dataUjian -> api_token = Str::random(60);

        $dataUjian ->save();
        return response() -> json(
            [   
                'status' => 200,
                'message' => 'data di simpan',
                'data' => $dataUjian
            ]
            );

    }

    public function getUJianDetail(Request $request){

        $token = explode(' ', $request->header('Authorization'));

        // $ujian = Ujian::where('api_token',$token[1])->first();
        $ujian = DB::table('ujians')
        ->select('id_ujian','nama_dosen','nama_matkul','nama_ujian','waktu_ujian','mulai','selesai','jlm_soal')
        ->join('dosens','ujians.id_dosen', '=', 'dosens.id_dosen')
        ->join('matkuls','ujians.id_matkul', '=', 'matkuls.id_matkul')
        ->where('ujians.api_token',$token[1])->first();


        if(!$ujian){
            return response()->json(
                [
                    'status' => 404,
                    'message' => "data Tidak Ada",
                ],404
            );
        }
        return response()->json(
            [
                'status' => 200,
                'message' => "Get Sucess",
                'data' => $ujian
            ],200
        );
    }

    public function loginUjian(Request $request){

        $pass_ujian = $request->input('pass_ujian');
        $kode_ujian = $request->input('kode_ujian');

        $dataLogin =  DB::table('ujians')
        ->select('id_ujian','api_token','kode_ujian','pass_ujian')
        ->where("kode_ujian", $kode_ujian)
        ->first();    
        
        if(!$dataLogin){
            return response()->json(
                [
                    'status' =>  400,
                    'message' => 'Login Tidak Berhasil',
                    'data' => 'Kode Ujian Salah'
                ],400
            );
        }
        if($pass_ujian !== $dataLogin->pass_ujian){
            return response()->json(
                [
                    'status' =>  400,
                    'message' => 'Login Tidak Berhasil',
                    'data' => 'Password Ujian Salah'
                ],400
            );
        }
            return response()->json(
                [
                'message' => 'login success',
                'data' => $dataLogin
            ]
        );
    }
    
    public function getUjianbyDosen(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        // $listUjian = Ujian::where('id_dosen', $id_dosen->id_dosen)->get();
        $listUjian = DB::table('ujians')
        ->select('id_ujian','nama_dosen','kode_ujian','pass_ujian','nama_matkul','nama_ujian','kelas','jlm_soal','waktu_ujian','mulai','selesai')
        ->join('dosens','ujians.id_dosen', '=', 'dosens.id_dosen')
        ->join('matkuls','ujians.id_matkul', '=', 'matkuls.id_matkul')
        ->where('ujians.id_dosen',$id_dosen->id_dosen)->get();

        return response() -> json([
            'status' => 200,
            'message' => 'get Success',
            'data' => $listUjian
        ]);
    }

    public function updateUjianByDosen(Request $request, $id) {
        // $token = explode(' ', $request->header('Authorization'));
        // $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        $updateUjian = Ujian::where('id_ujian', $id) -> first();

        if($updateUjian){
            $updateUjian -> id_dosen =  $request->id_dosen ? $request->$id_dosen : $updateUjian-> id_dosen ;
            $updateUjian -> id_matkul = $request -> id_matkul ? $request -> id_matkul : $updateUjian -> id_matkul ;
            $updateUjian -> kode_ujian = $request -> kode_ujian ? $request -> kode_ujian : $updateUjian->kode_ujian;
            $updateUjian -> pass_ujian = $request -> pass_ujian ? $request-> pass_ujian : $updateUjian-> pass_ujian;
            $updateUjian -> nama_ujian = $request -> nama_ujian ? $request-> nama_ujian : $updateUjian->nama_ujian;
            $updateUjian -> jlm_soal = $request -> jlm_soal ? $request-> jlm_soal : $updateUjian-> jlm_soal;
            $updateUjian -> waktu_ujian = $request -> waktu_ujian ? $request-> waktu_ujian : $updateUjian->waktu_ujian;
            $updateUjian -> mulai = $request -> mulai ? $request-> mulai : $updateUjian -> mulai;
            $updateUjian -> selesai = $request -> selesai ? $request-> selesai : $updateUjian -> selesai;
            $updateUjian -> api_token = Str::random(60) ;
            $updateUjian->save();
            return response()->json([
                'status' => 200,
                'message' => 'Update Berhasil',
                'data' => $updateUjian,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak di temukan',
                'data' => $updateUjian,
            ],404);
        }
    }

    public function deleteUjianByDosen(Request $request, $id){
        $deleteUjian =  Ujian::where('id_ujian', $id)->first();
        if($deleteUjian){
            $deleteUjian->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Delete Berhasil',
                'data' => $deleteUjian,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak di temukan',
                'data' => $deleteUjian,
            ],404);
        }
    }


    
}
