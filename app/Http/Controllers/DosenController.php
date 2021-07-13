<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;
class DosenController extends Controller
{
    // public function getData(){
    //     $dosen = DB::table('dosens')
		// 		->where('role', '=', 'dosen')
		// 		->get();
    //     return response()->json(
    //         [
    //             "message" => 'get Data sucess',
    //             "data" => $dosen
    //         ]
    //         );
    // }
    public function getData(){
        $dosen = Dosen::where('role', '=', 'dosen')->get();
        return response()->json(
            [
                "message" => 'get Data sucess',
                "data" => $dosen
            ]
            );
    }

    public function postData(Request $request){
			
			$this -> validate($request,[
				// 'nidn' => 'required|unique:dosens',
				'nama_dosen' => 'required',
				'password' => 'required|min:6',
				'prodi' => 'required',

			]);
			$dataDosen  = new Dosen;
			$dataDosen -> nidn = rand(100000, 999999);
			$dataDosen -> nama_dosen = $request->input('nama_dosen');
			$dataDosen -> password= Hash::make($request->input('password'));
			$dataDosen -> prodi = $request->input('prodi');
			$dataDosen -> role = "dosen";
			$dataDosen -> api_token = Hash::make(Str::random(60));

			$dataDosen -> save();
				return response() -> json(
					[
						'status' =>201,
						'message' => 'Data Berhasil Di simpan',
						'data' => $dataDosen
					],201
				);
		}
		
		public function addAdmin(Request $request) {
			$this -> validate($request,[
					// 'nidn' => 'required|unique:dosens',
					'nama_dosen' => 'required',
					'password' => 'required|min:6',
					'prodi' => 'required',

			]);
			$dataAdmin  = new Dosen;
			$dataAdmin -> nidn = rand(100000, 999999);
			$dataAdmin -> nama_dosen = $request->input('nama_dosen');
			$dataAdmin -> password= Hash::make($request->input('password'));
			$dataAdmin -> prodi = $request->input('prodi');
			$dataAdmin -> role = "admin";
			$dataAdmin -> api_token = Hash::make(Str::random(60));
			$dataAdmin -> save();
					return response() -> json(
							[
									'status' =>201,
									'message' => 'Data Berhasil Di simpan',
									'data' => $dataAdmin
							],201
					);
	}    
		public function deleteDosen(Request $request, $id) {
			$token = explode(' ', $request->header('Authorization'));
			$deleteDosen = Dosen::where('id_dosen',$id)->first();

			if($deleteDosen){
				$deleteDosen->delete();
				return response() -> json(
					[
						'status' =>200,
						'message' => 'Data Berhasil Dihapus',
						'data' => $deleteDosen
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
		
		public function editDosen(Request $request, $id){
			$token = explode(' ', $request->header('Authorization'));
			$editDosen = Dosen::where('id_dosen',$id)->first();

			
			if($editDosen){
				$editDosen -> nidn = $editDosen->nidn;
				$editDosen -> nama_dosen = $request->nama_dosen ? $request->nama_dosen : $editDosen->nama_dosen;
				$editDosen -> password= $request->password ? Hash::make($request->input('password')) : $editDosen->password;
				$editDosen -> prodi = $request->prodi ? $request->prodi : $editDosen -> prodi;
				$editDosen -> role = "dosen";
				$editDosen -> api_token = Hash::make(Str::random(60));
				$editDosen->save();
				return response() -> json(
					[
						'status' =>200,
						'message' => 'Data Berhasil Dirubah',
						'data' => $editDosen
					],200
				);
			}else{
				return response() -> json(
					[
						'status' =>404,
						'message' => 'Data Tidak Ditemukan',
					],404
				);
			}



		}




		public function getListSoal(Request $request){

			$token = explode(' ', $request->header('Authorization'));
			$id_dosen = DB::table('dosens')->select('id_dosen')->where('api_token',$token[1])->first();
			$listSoal = DB::table('essays')->where('id_dosen', $id_dosen->id_dosen)->get();

			return response() -> json(
				[
					'status' =>200,
					'message' => 'Data Berhasil Di simpan',
					'data' => $listSoal
				],200
			);
		}



		public function loginDosen(Request $request){

			$nidn = $request->input('nidn');
			$password = $request->input('password');
			
			// $loginDosen = DB::table('dosens')->where('nidn',"=",$nidn)->first();
			$loginDosen = Dosen::where('nidn',"=",$nidn)->first();
			
			if(!$loginDosen){
				return response()->json(
					[
							'message' => 'Login Tidak Berhasil',
							'data' => 'Cek NIDN Anda'
					],400
			);
		}
			if(!Hash::check($password, $loginDosen->password)){
				return response()->json(
					[
					'message' => 'Login Tidak Berhasil',
					'data' => 'Cek Password Anda'
					],400
					)
					;
			}
			return response()->json(
				[
				'status' => 200,
				'message' => 'Login Berhasil',
				'data' => $loginDosen
				],200
);

		}


		public function getDetailDosen(Request $request){
			$token = explode(' ', $request->header('Authorization'));
			$detailDosen = Dosen::where('api_token', $token[1])->first();

			return response()->json([
				'status' => 200,
				'message'=>'success',
				'data'=> $detailDosen
			]);
		}
	}