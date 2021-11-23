<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Ujian;
use App\Models\Dosen;
use App\Models\PG;
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
        $dataUjian -> jumlah_soal_essay = $request -> input("jumlah_soal_essay");
        $dataUjian -> jumlah_soal_PG = $request -> input("jumlah_soal_PG");
        $dataUjian -> type_soal = $request -> input("type_soal");
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
        ->select('id_ujian','nama_dosen','nama_matkul','nama_ujian','waktu_ujian','mulai','selesai','jumlah_soal_PG','jumlah_soal_essay','type_soal')
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
        ->select('id_ujian','nama_dosen','kode_ujian','pass_ujian','nama_matkul','nama_ujian','kelas','jumlah_soal_essay','jumlah_soal_PG','type_soal','waktu_ujian','mulai','selesai')
        ->join('dosens','ujians.id_dosen', '=', 'dosens.id_dosen')
        ->join('matkuls','ujians.id_matkul', '=', 'matkuls.id_matkul')
        ->where('ujians.id_dosen',$id_dosen->id_dosen)
        ->where('ujians.deleted_at','=',null)
        ->get();

        return response() -> json([
            'status' => 200,
            'message' => 'get Success',
            'data' => $listUjian
        ]);
    }
    public function getJumlahUjian(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token', $token[1])->first();

        // $id_matkul = DB::table('t_pg')->select('id_soalPG','id_matkul','type_ujian','type_soal','soal_pg')
        // ->where('id_dosen',$id_dosen->id_dosen)
        // ->where('type_ujian','=','UTS')
        // ->get();
        
        $countUjianPG = Ujian::where('id_dosen',$id_dosen->id_dosen)->where('type_soal','=','PG')->count();
        $countUjianEssay = Ujian::where('id_dosen',$id_dosen->id_dosen)->where('type_soal','=','Essay')->count();
        $countUjianMix= Ujian::where('id_dosen',$id_dosen->id_dosen)->where('type_soal','=','PG Dan Essay')->count();

        
        return response() -> json([
            'status' => 200,
            'message' => 'get Success',
            'dataPG' => $countUjianPG,
            'dataEssay' => $countUjianEssay,
            'dataMix' => $countUjianMix

        ]);

    }

    public function updateUjianByDosen(Request $request, $id) {
        // $token = explode(' ', $request->header('Authorization'));
        // $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
        $updateUjian = Ujian::where('id_ujian', $id) -> first();

        if($updateUjian){
            if($request->type_soal === 'PG'){
                $updateUjian -> id_dosen =  $request->id_dosen ? $request->$id_dosen : $updateUjian-> id_dosen ;
                $updateUjian -> id_matkul = $request -> id_matkul ? $request -> id_matkul : $updateUjian -> id_matkul ;
                $updateUjian -> kode_ujian = $request -> kode_ujian ? $request -> kode_ujian : $updateUjian->kode_ujian;
                $updateUjian -> pass_ujian = $request -> pass_ujian ? $request-> pass_ujian : $updateUjian-> pass_ujian;
                $updateUjian -> nama_ujian = $request -> nama_ujian ? $request-> nama_ujian : $updateUjian->nama_ujian;
                $updateUjian -> jumlah_soal_PG = $request -> jumlah_soal_PG ? $request-> jumlah_soal_PG : $updateUjian-> jumlah_soal_PG;
                // $updateUjian -> jumlah_soal_essay = $request -> jumlah_soal_essay ? $request-> jumlah_soal_essay : $updateUjian-> jumlah_soal_essay;
                $updateUjian -> jumlah_soal_essay = null;
                $updateUjian -> waktu_ujian = $request -> waktu_ujian ? $request-> waktu_ujian : $updateUjian->waktu_ujian;
                $updateUjian -> type_soal = $request -> type_soal ? $request-> type_soal : $updateUjian->type_soal;
                $updateUjian -> mulai = $request -> mulai ? $request-> mulai : $updateUjian -> mulai;
                $updateUjian -> selesai = $request -> selesai ? $request-> selesai : $updateUjian -> selesai;
                $updateUjian -> api_token =$updateUjian->api_token;
                $updateUjian->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Update Berhasil',
                    'data' => $updateUjian,
                ],200);
            }
            if($request->type_soal === 'Essay'){
                $updateUjian -> id_dosen =  $request->id_dosen ? $request->$id_dosen : $updateUjian-> id_dosen ;
                $updateUjian -> id_matkul = $request -> id_matkul ? $request -> id_matkul : $updateUjian -> id_matkul ;
                $updateUjian -> kode_ujian = $request -> kode_ujian ? $request -> kode_ujian : $updateUjian->kode_ujian;
                $updateUjian -> pass_ujian = $request -> pass_ujian ? $request-> pass_ujian : $updateUjian-> pass_ujian;
                $updateUjian -> nama_ujian = $request -> nama_ujian ? $request-> nama_ujian : $updateUjian->nama_ujian;
                // $updateUjian -> jumlah_soal_PG = $request -> jumlah_soal_PG ? $request-> jumlah_soal_PG : $updateUjian-> jumlah_soal_PG;
                $updateUjian -> jumlah_soal_PG = null;
                $updateUjian -> jumlah_soal_essay = $request -> jumlah_soal_essay ? $request-> jumlah_soal_essay : $updateUjian-> jumlah_soal_essay;
                // $updateUjian -> jumlah_soal_essay = null;
                $updateUjian -> waktu_ujian = $request -> waktu_ujian ? $request-> waktu_ujian : $updateUjian->waktu_ujian;
                $updateUjian -> type_soal = $request -> type_soal ? $request-> type_soal : $updateUjian->type_soal;
                $updateUjian -> mulai = $request -> mulai ? $request-> mulai : $updateUjian -> mulai;
                $updateUjian -> selesai = $request -> selesai ? $request-> selesai : $updateUjian -> selesai;
                $updateUjian -> api_token =$updateUjian->api_token;
                $updateUjian->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Update Berhasil',
                    'data' => $updateUjian,
                ],200);
            }
            if($request->type_soal === 'PG Dan Essay'){
                $updateUjian -> id_dosen =  $request->id_dosen ? $request->$id_dosen : $updateUjian-> id_dosen ;
                $updateUjian -> id_matkul = $request -> id_matkul ? $request -> id_matkul : $updateUjian -> id_matkul ;
                $updateUjian -> kode_ujian = $request -> kode_ujian ? $request -> kode_ujian : $updateUjian->kode_ujian;
                $updateUjian -> pass_ujian = $request -> pass_ujian ? $request-> pass_ujian : $updateUjian-> pass_ujian;
                $updateUjian -> nama_ujian = $request -> nama_ujian ? $request-> nama_ujian : $updateUjian->nama_ujian;
                $updateUjian -> jumlah_soal_PG = $request -> jumlah_soal_PG ? $request-> jumlah_soal_PG : $updateUjian-> jumlah_soal_PG;
                // $updateUjian -> jumlah_soal_PG = null;
                $updateUjian -> jumlah_soal_essay = $request -> jumlah_soal_essay ? $request-> jumlah_soal_essay : $updateUjian-> jumlah_soal_essay;
                // $updateUjian -> jumlah_soal_essay = null;
                $updateUjian -> waktu_ujian = $request -> waktu_ujian ? $request-> waktu_ujian : $updateUjian->waktu_ujian;
                $updateUjian -> type_soal = $request -> type_soal ? $request-> type_soal : $updateUjian->type_soal;
                $updateUjian -> mulai = $request -> mulai ? $request-> mulai : $updateUjian -> mulai;
                $updateUjian -> selesai = $request -> selesai ? $request-> selesai : $updateUjian -> selesai;
                $updateUjian -> api_token =$updateUjian->api_token;
                $updateUjian->save();
                return response()->json([
                    'status' => 200,
                    'message' => 'Update Berhasil',
                    'data' => $updateUjian,
                ],200);
            }
            
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
