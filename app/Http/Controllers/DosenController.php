<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dosen;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;  
use Illuminate\Support\Str;
class DosenController extends Controller
{
    public function getData(){
        $dosen = DB::table('dosens')->get();
        return response()->json(
            [
                "message" => 'get Data sucess',
                "data" => $dosen
            ]
            );
    }

    public function postData(Request $request){
			
			$this -> validate($request,[
				'nidn' => 'required|unique:dosens',
				'nama_dosen' => 'required',
				'password' => 'required|min:6',
				'prodi' => 'required',

			]);
			$dataDosen  = new Dosen;
			$dataDosen -> nidn = $request->input('nidn');
			$dataDosen -> nama_dosen = $request->input('nama_dosen');
			$dataDosen -> password= Hash::make($request->input('password'));
			$dataDosen -> prodi = $request->input('prodi');
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

		public function loginDosen(Request $request){

			$nidn = $request->input('nidn');
			$password = $request->input('password');
			
			$loginDosen = DB::table('dosens')->where('nidn',"=",$nidn)->first();

		// 	return response()->json(
		// 		[
		// 				'message' => 'login berhasil',
		// 				'data' => $loginDosen
		// 		]
		// );
			if(!$loginDosen){
				return response()->json(
					[
							'message' => 'login gagal',
							'data' => 'Cek nidn'
					],400
			);
		}
			if(!Hash::check($password, $loginDosen->password)){
				return response()->json(
					[
					'message' => 'login gagal',
					'data' => 'cek password'
					],400
					)
					;
			}
			return response()->json(
				[
				'status' => 200,
				'message' => 'login success',
				'data' => $loginDosen
				],200
);
				
			
			// $loginDosen = DB::table('dosens')
			// 	->select('id_dosen','api_token')
      //   ->where("nidn", $request->nidn)
      //   ->first();   

			// 	if($loginDosen === null){
			// 		return response()->json(
			// 				[
			// 						'message' => 'login gagal',
			// 						'data' => 'Dosen tidak di temukan'
			// 				]
			// 		);
			// }else{

			
			// 		return response()->json(
			// 				[
			// 				'status' => 200,
			// 				'message' => 'login success',
			// 				'data' => $nidn
			// 				],200
			// );
			// };
		}
	}