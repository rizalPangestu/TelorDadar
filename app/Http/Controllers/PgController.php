<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PG;
use App\Models\Ujian;
use Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File; 
use App\User;
use Illuminate\Support\Str;
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
    public function getSoalUjian(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $dataSoal = Ujian::where('api_token',$token[1])->first();

        if($dataSoal->type_soal === "PG Dan Essay"){
            $getSoalUjianPG = DB::table('t_pg')
            ->where('id_dosen', $dataSoal->id_dosen)
            ->where('id_matkul', $dataSoal->id_matkul)
            ->where('type_ujian', $dataSoal->nama_ujian)
            ->where('type_soal', 'PG')
            ->inRandomOrder()
            ->limit($dataSoal->jumlah_soal_PG)
            ->get();

            $getSoalUjianEssay = DB::table('t_pg')
            ->where('id_dosen', $dataSoal->id_dosen)
            ->where('id_matkul', $dataSoal->id_matkul)
            ->where('type_ujian', $dataSoal->nama_ujian)
            ->where('type_soal', "Essay")
            ->inRandomOrder()
            ->limit($dataSoal->jumlah_soal_essay)
            ->get();

            // return response()->json([
            //     'status'=>200,
            //     'message'=>"succes",
            //     'type' => 1,
            //     'data'=>$getSoalUjianPG,
            //     'data2'=>$getSoalUjianEssay,

            // ]);
        }
        if($dataSoal->type_soal === "PG"){
            $getSoalUjian = DB::table('t_pg')
            // ->join('dosens', 'essays.id_dosen', '=', 'dosens.id_dosen')
            // ->join('matkuls', 'essays.id_matkul', '=', 'matkuls.id_matkul')
            ->where('id_dosen', $dataSoal->id_dosen)
            ->where('id_matkul', $dataSoal->id_matkul)
            ->where('type_ujian', $dataSoal->nama_ujian)
            ->where('type_soal', $dataSoal->type_soal)
            ->inRandomOrder()
            ->limit($dataSoal->jumlah_soal_PG)
            ->get();

            // return response()->json([
            //     'status'=>200,
            //     'message'=>"succes",
            //     'type' => 0,
            //     'data'=>$getSoalUjian,
            // ]);
        } 
        if($dataSoal->type_soal === "Essay"){
            $getSoalUjian = DB::table('t_pg')
            // ->join('dosens', 'essays.id_dosen', '=', 'dosens.id_dosen')
            // ->join('matkuls', 'essays.id_matkul', '=', 'matkuls.id_matkul')
            ->where('id_dosen', $dataSoal->id_dosen)
            ->where('id_matkul', $dataSoal->id_matkul)
            ->where('type_ujian', $dataSoal->nama_ujian)
            ->where('type_soal', $dataSoal->type_soal)
            ->inRandomOrder()
            ->limit($dataSoal->jumlah_soal_essay)
            ->get();

            // return response()->json([
            //     'status'=>200,
            //     'message'=>"succes",
            //     'type' => 0,
            //     'data'=>$getSoalUjian,
            // ]);
        }

        if($dataSoal->type_soal === "PG Dan Essay"){
            return response()->json([
                'status'=>200,
                'message'=>"succes",
                'type' => 1,
                'data'=>$getSoalUjianPG,
                'data2'=>$getSoalUjianEssay,

            ]);
        }else{
            return response()->json([
                'status'=>200,
                'message'=>"succes",
                'type' => 0,
                'data'=>$getSoalUjian,
            ]);
        }

    }

    public function addSoalPG(Request $request){
        $token = explode(' ', $request->header('Authorization'));
        $id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();

        // $validator = Validator::make($request->all(),[ 
        //     'soal_gambar' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'gambar_pil_a' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'gambar_pil_b' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'gambar_pil_c' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'gambar_pil_d' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        //     'gambar_pil_e' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        // ]); 

        // if($validator->fails()) {          
        //     return response()->json(['error'=>$validator->errors()], 403);                        
        // }

        if($request->file('soal_gambar') !=  null){
            $image_soal = $request->file('soal_gambar');
            $filename = time().$image_soal->getClientOriginalName();
            $path = $request->file('soal_gambar')->move(public_path("/storage/images/soalPg"), $filename);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL = url('/storage/images/soalPg/'.$filename);
        }else{
            $filename = null;
        }
        if($request->file('gambar_pil_a') !=  null){
            $image_pilA = $request->file('gambar_pil_a');
            $image_pilA_name = time().$image_pilA->getClientOriginalName();
            $path_pilA = $request->file('gambar_pil_a')->move(public_path("/storage/images/jawabanPg"),$image_pilA_name);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL_pilA = url('/storage/images/jawabanPg/'.$image_pilA_name);
        }else{
            $image_pilA_name = null;
        }

        if($request->file('gambar_pil_b') !=  null){
            $image_pilB = $request->file('gambar_pil_b');
            $image_pilB_name = time().$image_pilB->getClientOriginalName();
            $path_pilB = $request->file('gambar_pil_b')->move(public_path("/storage/images/jawabanPg"),$image_pilB_name);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL_pilB = url('/storage/images/jawabanPg/'.$image_pilB_name);
        }else{
            $image_pilB_name = null;
        }

        if($request->file('gambar_pil_c') !=  null){
            $image_pilC = $request->file('gambar_pil_c');
            $image_pilC_name = time().$image_pilC->getClientOriginalName();
            $path_pilC = $request->file('gambar_pil_c')->move(public_path("/storage/images/jawabanPg"),$image_pilC_name);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL_pilC = url('/storage/images/jawabanPg/'.$image_pilC_name);
        }else{
            $image_pilC_name = null;
        }

        if($request->file('gambar_pil_d') !=  null){
            $image_pilD = $request->file('gambar_pil_d');
            $image_pilD_name = time().$image_pilD->getClientOriginalName();
            $path_pilD = $request->file('gambar_pil_d')->move(public_path("/storage/images/jawabanPg"),$image_pilD_name);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL_pilD = url('/storage/images/jawabanPg/'.$image_pilD_name);
        }else{
            $image_pilD_name = null;
        }

        if($request->file('gambar_pil_e') !=  null){
            $image_pilE = $request->file('gambar_pil_e');
            $image_pilE_name = time().$image_pilE->getClientOriginalName();
            $path_pilE = $request->file('gambar_pil_e')->move(public_path("/storage/images/jawabanPg"),$image_pilE_name);
        
            // $path = $request->file('soal_gambar')->move(public_path("/"), $filename);
            $imagesURL_pilE = url('/storage/images/jawabanPg/'.$image_pilE_name);
        }else{
            $image_pilE_name = null;
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
        $addSoalPG -> type_ujian = $request -> input('type_ujian');
        $addSoalPG -> type_soal = $request -> input('type_soal');
        $addSoalPG -> kunci_pg = $request -> input('kunci_pg');
        $addSoalPG -> kunci_essay = $request -> input('kunci_essay');
        
        //input gambar
        $addSoalPG -> soal_gambar = $filename;
        $addSoalPG -> gambar_pil_a = $image_pilA_name;
        $addSoalPG -> gambar_pil_b = $image_pilB_name;
        $addSoalPG -> gambar_pil_c = $image_pilC_name;
        $addSoalPG -> gambar_pil_d = $image_pilD_name;
        $addSoalPG -> gambar_pil_e = $image_pilE_name;

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

        // $listSoalbyDosen = PG::where('id_dosen', $id_dosen->id_dosen)
        // ->get();

        $listSoalbyDosen = DB::table('t_pg')
        ->join('matkuls','t_pg.id_matkul', '=', 'matkuls.id_matkul')
        ->select("t_pg.*","matkuls.nama_matkul")
        ->where('t_pg.id_dosen', $id_dosen->id_dosen)->get();

        return response()->json([
            'status' => 200,
            'message' => 'get success',
            'data' => $listSoalbyDosen
        ],200);
    }

    public function getDetailSoal(Request $request, $id){
        $detailSoal = PG::where('id_soalPG', $id )
        ->join('matkuls','t_pg.id_matkul', '=', 'matkuls.id_matkul')
        ->first();
        if($detailSoal){
            return response()->json([
                'status' => 200,
                'message' => 'get success',
                'id' => $detailSoal
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'get Failed, data not found',
                'id' => $id
            ],404);
        }
    }


    public function deleteSoal(Request $request, $id){
        $deleteSoal =  PG::where('id_soalPG', $id)->first();
        if($deleteSoal){
            if($deleteSoal->soal_gambar){
                $filename = $deleteSoal->soal_gambar;
                $file_path = str_replace('\\','/',public_path('storage/images/soalPg/'));
                unlink($file_path.$filename);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            if($deleteSoal -> gambar_pil_a) {
                $filename_pilA = $deleteSoal->gambar_pil_a;
                $file_path_pilA = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                unlink($file_path_pilA.$filename_pilA);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            if($deleteSoal -> gambar_pil_b) {
                $filename_pilB = $deleteSoal->gambar_pil_b;
                $file_path_pilB = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                unlink($file_path_pilB.$filename_pilB);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            if($deleteSoal -> gambar_pil_c) {
                $filename_pilC = $deleteSoal->gambar_pil_c;
                $file_path_pilC = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                unlink($file_path_pilC.$filename_pilC);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            if($deleteSoal -> gambar_pil_d) {
                $filename_pilD = $deleteSoal->gambar_pil_d;
                $file_path_pilD = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                unlink($file_path_pilD.$filename_pilD);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            if($deleteSoal -> gambar_pil_e) {
                $filename_pilE = $deleteSoal->gambar_pil_e;
                $file_path_pilE = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                unlink($file_path_pilE.$filename_pilE);
                // Storage::delete($file_path);
                // Storage::delete();
                $deleteSoal->delete();
            }
            $deleteSoal->delete();
            return response()->json([
                'status' => 200,
                'message' => 'Delete Berhasil',
                'data' => $deleteSoal,
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak di temukan',
                'data' => $deleteSoal,
            ],404);
        }
    }

    public function updateSoal(Request $request, $id){

        $updateSoal = PG::where('id_soalPG', $id)->first();

        
        if($updateSoal){
            $updateSoal-> id_matkul = $request->id_matkul ? $request -> id_matkul : $updateSoal -> id_matkul ;
            $updateSoal -> type_ujian = $request -> type_ujian ? $request -> type_ujian : $updateSoal -> type_ujian;
            $updateSoal -> soal_pg = $request -> soal_pg ? $request -> soal_pg : $updateSoal -> soal_pg;
            $updateSoal -> pil_a = $request -> pil_a ? $request -> pil_a : $updateSoal -> pil_a;
            $updateSoal -> pil_b = $request -> pil_b ? $request -> pil_b : $updateSoal -> pil_b;
            $updateSoal -> pil_c = $request -> pil_c ? $request -> pil_c : $updateSoal -> pil_c;
            $updateSoal -> pil_d = $request -> pil_d ? $request -> pil_d : $updateSoal -> pil_d;
            $updateSoal -> pil_e = $request -> pil_e ? $request -> pil_e : $updateSoal -> pil_e;
            $updateSoal -> kunci_pg = $request ->kunci_pg ? $request -> kunci_pg : $updateSoal -> kunci_pg;
            $updateSoal -> kunci_essay = $request -> kunci_essay ? $request -> kunci_essay : $updateSoal -> kunci_essay;


            if($request->file('soal_gambar') !=  null){
                if($updateSoal -> soal_gambar){
                    //delete
                    $filename = $updateSoal->soal_gambar;
                    $file_path = str_replace('\\','/',public_path('storage/images/soalPg/'));
                    unlink($file_path.$filename);
                    // replace
                    $replace_image = $request->file('soal_gambar');
                    $filenameNew = time().$replace_image->getClientOriginalName();
                    $path = $request->file('soal_gambar')->move(public_path("/storage/images/soalPg"), $filenameNew);
                }else{
                    $replace_image = $request->file('soal_gambar');
                    $filenameNew = time().$replace_image->getClientOriginalName();
                    $path = $request->file('soal_gambar')->move(public_path("/storage/images/soalPg"), $filenameNew);
                }
                
            }else{
                $filenameNew = null;
                // //replace
                // $replace_image = $request->file('soal_gambar');
                // $filename = time().$replace_image->getClientOriginalName();
                // $path = $request->file('soal_gambar')->move(public_path("/storage/images/soalPg"), $filename);
            }
            $updateSoal -> soal_gambar = $filenameNew ? $filenameNew :  $updateSoal -> soal_gambar;

            if($request->file('gambar_pil_a') !=  null){
                if($updateSoal -> gambar_pil_a){
                    //delete
                    $filenameNew_pilA = $updateSoal->gambar_pil_a;
                    $file_pathNew_pilA = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                    unlink($file_pathNew_pilA.$filenameNew_pilA);
                    // replace
                    $replace_image_pilA = $request->file('gambar_pil_a');
                    $filenameNew_pilA = time().$replace_image_pilA->getClientOriginalName();
                    $path_pilA = $request->file('gambar_pil_a')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilA);
                }else{
                    $replace_image_pilA = $request->file('gambar_pil_a');
                    $filenameNew_pilA = time().$replace_image_pilA->getClientOriginalName();
                    $path_pilA = $request->file('gambar_pil_a')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilA);
                }
                
            }else{
                $filenameNew_pilA = null;
            }
            $updateSoal -> gambar_pil_a = $filenameNew_pilA ? $filenameNew_pilA :  $updateSoal -> gambar_pil_a;
            
            if($request->file('gambar_pil_b') !=  null){
                if($updateSoal -> gambar_pil_b){
                    //delete
                    $filenameNew_pilB = $updateSoal->gambar_pil_b;
                    $file_pathNew_pilB = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                    unlink($file_pathNew_pilB.$filenameNew_pilB);
                    // replace
                    $replace_image_pilB = $request->file('gambar_pil_b');
                    $filenameNew_pilB = time().$replace_image_pilB->getClientOriginalName();
                    $path_pilB = $request->file('gambar_pil_b')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilB);
                }else{
                    $replace_image_pilB = $request->file('gambar_pil_b');
                    $filenameNew_pilB = time().$replace_image_pilB->getClientOriginalName();
                    $path_pilB = $request->file('gambar_pil_b')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilB);
                }
                
            }else{
                $filenameNew_pilB = null;
            }
            $updateSoal -> gambar_pil_b = $filenameNew_pilB ? $filenameNew_pilB :  $updateSoal -> gambar_pil_b;
            
            if($request->file('gambar_pil_c') !=  null){
                if($updateSoal -> gambar_pil_c){
                    //delete
                    $filenameNew_pilC = $updateSoal->gambar_pil_c;
                    $file_pathNew_pilC = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                    unlink($file_pathNew_pilC.$filenameNew_pilC);
                    // replace
                    $replace_image_pilC = $request->file('gambar_pil_c');
                    $filenameNew_pilC = time().$replace_image_pilC->getClientOriginalName();
                    $path_pilC = $request->file('gambar_pil_c')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilC);
                }else{
                    $replace_image_pilC = $request->file('gambar_pil_c');
                    $filenameNew_pilC = time().$replace_image_pilC->getClientOriginalName();
                    $path_pilC = $request->file('gambar_pil_c')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilC);
                }
                
            }else{
                $filenameNew_pilC = null;
            }
            $updateSoal -> gambar_pil_c = $filenameNew_pilC ? $filenameNew_pilC :  $updateSoal -> gambar_pil_c;

            if($request->file('gambar_pil_d') !=  null){
                if($updateSoal -> gambar_pil_d){
                    //delete
                    $filenameNew_pilD = $updateSoal->gambar_pil_d;
                    $file_pathNew_pilD = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                    unlink($file_pathNew_pilD.$filenameNew_pilD);
                    // replace
                    $replace_image_pilD = $request->file('gambar_pil_d');
                    $filenameNew_pilD = time().$replace_image_pilD->getClientOriginalName();
                    $path_pilD = $request->file('gambar_pil_d')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilD);
                }else{
                    $replace_image_pilD = $request->file('gambar_pil_d');
                    $filenameNew_pilD = time().$replace_image_pilD->getClientOriginalName();
                    $path_pilD = $request->file('gambar_pil_d')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilD);
                }
                
            }else{
                $filenameNew_pilD = null;
            }
            $updateSoal -> gambar_pil_d = $filenameNew_pilD ? $filenameNew_pilD :  $updateSoal -> gambar_pil_d;

            if($request->file('gambar_pil_e') !=  null){
                if($updateSoal -> gambar_pil_e){
                    //delete
                    $filenameNew_pilE = $updateSoal->gambar_pil_e;
                    $file_pathNew_pilE = str_replace('\\','/',public_path('storage/images/jawabanPg/'));
                    unlink($file_pathNew_pilE.$filenameNew_pilE);
                    // replace
                    $replace_image_pilE = $request->file('gambar_pil_e');
                    $filenameNew_pilE = time().$replace_image_pilE->getClientOriginalName();
                    $path_pilE = $request->file('gambar_pil_e')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilE);
                }else{
                    $replace_image_pilE = $request->file('gambar_pil_e');
                    $filenameNew_pilE = time().$replace_image_pilE->getClientOriginalName();
                    $path_pilE = $request->file('gambar_pil_e')->move(public_path("/storage/images/jawabanPg"), $filenameNew_pilE);
                }
                
            }else{
                $filenameNew_pilE = null;
            }
            $updateSoal -> gambar_pil_e = $filenameNew_pilE ? $filenameNew_pilE :  $updateSoal -> gambar_pil_e;
            $updateSoal->save();
            return response()->json([
                'status' => 200,
                'message' => 'Data berhasil di ubah',
                'data' => $updateSoal
            ],200);
        }else{
            return response()->json([
                'status' => 404,
                'message' => 'Data tidak ada',
                'data' => $updateSoal
                
            ],404);
        }
    }
    
}
