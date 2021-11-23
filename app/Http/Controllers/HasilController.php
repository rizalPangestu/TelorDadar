<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Hasil;
use App\Models\Ujian;
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

    public function editHasilUjian(Request $request, $id){
        
        $updateHasil =  Hasil::where('id_hasil', $id)->first();
        $ujian = Ujian::where('id_ujian', $updateHasil->id_ujian) -> first();

        if($updateHasil){
            $updateHasil -> id_ujian = $updateHasil->id_ujian ;
            $updateHasil -> id_dosen = $updateHasil -> id_dosen;
            $updateHasil -> id_matkul= $updateHasil -> id_matkul;
            $updateHasil -> email = $updateHasil -> email ;
            $updateHasil -> nim = $updateHasil -> nim;
            $updateHasil ->nama_mhs = $updateHasil -> nama_mhs;
            $updateHasil ->point = $request->point  ? $request->nilai_essay  : $updateHasil -> point;
            $updateHasil ->nilai_pg =ceil(($updateHasil->point / $ujian->jumlah_soal_PG ) * 100);
            $updateHasil ->jawaban_essay = $updateHasil->jawaban_essay;
            $updateHasil ->nilai_essay =$request->nilai_essay ? $request->nilai_essay : $updateHasil->nilai_essay;
            $updateHasil ->nilai_akhir = ceil(($updateHasil->nilai_pg + $updateHasil->nilai_essay) / 2);
            $updateHasil->save();
            return response()->json([
                'status' => 200,
                'message' => 'Hasil Berhasil diRubah',
                'data' => $updateHasil
            ]); 
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Hasil Tidak Di Temukan',
                'data' => $updateHasil
            ]); 
        }
    }
    public function deleteHasilUjian(Request $request, $id){
        $deleteHasil =  Hasil::where('id_hasil', $id)->first();
        if($deleteHasil){
            $deleteHasil->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Delete Berhasil',
                'data' => $deleteHasil,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak di temukan',
                'data' => $deleteHasil,
            ],404);
        }
    }

    public function postHasilUjian(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $ujian = DB::table('ujians')->select('id_ujian', 'id_dosen', 'id_matkul','jumlah_soal_PG','type_soal')->where('api_token',$token[1])->first();
        $hasil = DB::table('hasils')->select('id_ujian', 'nim')
                ->where('id_ujian',$ujian->id_ujian)
                ->where('nim', $request->nim)
                ->first();
        if($hasil){
            return response()->json([
                'status' => 400,
                'message' => 'Anda Telah Mengikuti Ujian',
            ]);
        }else{
            if($ujian->type_soal === "PG Dan Essay"){
                $dataHasil  = new Hasil;
                $dataHasil -> id_ujian = $ujian->id_ujian;
                $dataHasil -> id_dosen = $ujian -> id_dosen;
                $dataHasil -> id_matkul= $ujian -> id_matkul;
                $dataHasil -> email = $request->input('email');
                $dataHasil -> nim = $request->input('nim');
                $dataHasil ->nama_mhs = $request->nama_mhs;
                $dataHasil ->point =$request->point;
                $dataHasil ->nilai_pg =ceil(($dataHasil->point / $ujian->jumlah_soal_PG ) * 100);
                // $dataHasil ->jawaban_essay = str_replace(",",null,json_encode($request->jawaban_essay));
                $dataHasil ->jawaban_essay = json_encode($request->jawaban_essay);
                $dataHasil ->nilai_essay =$request->nilai_essay;
                $dataHasil ->nilai_akhir = ceil(($dataHasil->nilai_pg + $dataHasil->nilai_essay) / 2);
        
                $dataHasil -> save();
                 return response()->json([
                    'status' => 200,
                    'message' => 'Post sucess',
                    'ujian' => $ujian->type_soal,
                    'data' => $dataHasil,
                ]);
            }elseif($ujian->type_soal === "PG"){
                $dataHasil  = new Hasil;
                $dataHasil -> id_ujian = $ujian->id_ujian;
                $dataHasil -> id_dosen = $ujian -> id_dosen;
                $dataHasil -> id_matkul= $ujian -> id_matkul;
                $dataHasil -> email = $request->input('email');
                $dataHasil -> nim = $request->input('nim');
                $dataHasil ->nama_mhs = $request->nama_mhs;
                $dataHasil ->point =$request->point;
                $dataHasil ->nilai_pg =ceil(($dataHasil->point / $ujian->jumlah_soal_PG )*100);
                // $dataHasil ->nilai_pg = ($dataHasil->point / $ujian->jumlah_soal_PG ) * 100;
                // $dataHasil ->jawaban_essay = str_replace(",",null,json_encode($request->nama_mhs));
                // $dataHasil ->nilai_essay =$request->nilai_essay;
                $dataHasil ->nilai_akhir = $dataHasil->nilai_pg;
        
                $dataHasil -> save();
                 return response()->json([
                    'status' => 200,
                    'message' => 'Post sucess',
                    'ujian' => $ujian->type_soal,
                    'data' => $dataHasil,
                ]);
            }else{
                $dataHasil  = new Hasil;
                $dataHasil -> id_ujian = $ujian->id_ujian;
                $dataHasil -> id_dosen = $ujian -> id_dosen;
                $dataHasil -> id_matkul= $ujian -> id_matkul;
                $dataHasil -> email = $request->input('email');
                $dataHasil -> nim = $request->input('nim');
                $dataHasil ->nama_mhs = $request->nama_mhs;
                // $dataHasil ->point =$request->point;
                // $dataHasil ->nilai_pg =($dataHasil->point / $ujian->jlm_soal ) * 100;
                $dataHasil ->jawaban_essay = str_replace(",",null,json_encode($request->jawaban_essay));
                $dataHasil ->nilai_essay =$request->nilai_essay;
                $dataHasil ->nilai_akhir = $dataHasil->nilai_essay;
        
                $dataHasil -> save();
                 return response()->json([
                    'status' => 200,
                    'message' => 'Post sucess',
                    'ujian' => $ujian->type_soal,
                    'data' => $dataHasil,
                ]);
            }
        }

    }
}
