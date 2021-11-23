<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Dosen;
use App\Models\Matkul;
class MatkulController extends Controller
{
    //
    public function getMatkul(){
        $matkul = DB::table('matkuls')
        ->select('id_matkul','nama_dosen','nidn', 'nama_matkul','matkuls.prodi','kelas','matkuls.updated_at')
        ->where('matkuls.deleted_at','=',NULL)
        ->join('dosens','matkuls.id_dosen', '=', 'dosens.id_dosen')
        ->get();
        
        return response()->json(
            [
                'message' => 'Get data succes',
                'status' => 200,
                'data' => $matkul
            ]
            );
    }
    public function count() {
        $matkulCount = Matkul::count();
        $dosenCount = Dosen::count();

        return response()->json(
            [
                'message' => 'Get data succes',
                'status' => 200,
                'matkul' => $matkulCount,
                'dosen' => $dosenCount
            ]
            );
    }


    public function addMatkul(Request $request){

        $listMatkul = Matkul::where('id_dosen', '=', $request->input('id_dosen'))->where('nama_matkul','=' , $request->input('nama_matkul'))->first();

        // $addMatkul = new Matkul;
        // $addMatkul -> nama_matkul = $request->input('nama_matkul');
        // $addMatkul -> id_dosen = $request->input('id_dosen');
        // $addMatkul -> kelas = $request->input('kelas');
        // $addMatkul -> prodi = $request->input('prodi');
        // $addMatkul ->save();


        // if($listMatkul->id_dosen == $request->input('id_dosen') && $listMatkul->nama_matkul === $request->input('nama_matkul')){
        if($listMatkul === null){ 
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
        }else{
            return response()->json(
                [
                    'message' => 'Gagal Di tambah',
                    'status' => 400,
                ],400
                );
           
        }
        // }else{
        //     $addMatkul ->save();
        //     return response()->json(
        //         [
        //             'message' => 'Berhasil Di tambah',
        //             'status' => 200,
        //             'data' => $addMatkul
        //         ]
        //         );
        //     }
            return response()->json(
                [
                    'message' => 'Berhasil Di tambah',
                    'status' => 200,
                    'data' => $listMatkul->id_dosen
                ]
                );
    }

    public function editMatkul(Request $request, $id){
        
        $editMatkul = Matkul::where('id_matkul',$id)->first();
        if($editMatkul){
            $editMatkul -> nama_matkul = $request->nama_matkul ? $request->nama_matkul : $editMatkul->nama_matkul;
            $editMatkul -> id_dosen = $request->id_dosen ? $request->id_dosen : $editMatkul->id_dosen;
            $editMatkul -> kelas = $request->kelas ? $request->kelas : $editMatkul->kelas;
            $editMatkul -> prodi = $request->prodi ? $request->prodi : $editMatkul->prodi; 
            $editMatkul ->save();
            return response()->json(
                [
                    'message' => 'Berhasil Dirubah',
                    'status' => 200,
                    'data' => $editMatkul
                ],200
                );
        }else{
            return response()->json(
                [
                    'message' => 'Data Tidak ditemukan',
                    'status' => 404,
                    'data' => $editMatkul
                ],404
                ); 
        }
    }


    public function deleteMatkul(Request $request, $id){
        $token = explode(' ', $request->header('Authorization'));
		$deleteMatkul = Matkul::where('id_matkul',$id)->first();

			if($deleteMatkul){
				$deleteMatkul->delete();
				return response() -> json(
					[
						'status' =>200,
						'message' => 'Data Berhasil Dihapus',
						'data' => $deleteMatkul
					],200
				);
				
			}else{
				return response() -> json(
					[
						'status' =>404,
						'message' => 'Data tidak ditemukan',
					],404
				);
			}
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
