<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('/dosen',function(){
//     return response()->json(
//         [
//             'message' => 'get method Succes'
//         ]
//         );
// });
use App\Http\Controllers\DosenController;
use App\Http\Controllers\UjiansController;
use App\Http\Controllers\MatkulController;
use App\Http\Controllers\SoalController;
use App\Http\Controllers\PgController;
use App\Http\Controllers\HasilController;
use App\Http\Controllers\UserController;



//route api dosen

Route::group(['middleware' => 'dosen_auth'], function() {

  //data dosen
  Route::get('/dosen', [DosenController::class, 'getData']);
  Route::get('/dosenDetail', [DosenController::class, 'getDetailDosen']);

  //add dosen (admin)
  Route::post('/dosen', [DosenController::class, 'postData']);
  Route::put('/editDosen/{id}', [DosenController::class, 'editDosen']);
  Route::delete('/deleteDosen/{id}', [DosenController::class, 'deleteDosen']);


  Route::post('/matkul', [MatkulController::class, 'addMatkul']);
  Route::put('/editMatkul/{id}', [MatkulController::class, 'editMatkul']);
  Route::delete('/deleteMatkul/{id}', [MatkulController::class, 'deleteMatkul']);
  Route::get('/matkul', [MatkulController::class, 'getMatkul']);
  Route::get('/matkulCount', [MatkulController::class, 'count']);

  //get soal
  Route::get('/soal_dosen', [DosenController::class, 'getListSoal']);
  Route::post('/soalujian', [SoalController::class, 'addSoal']);
  Route::get('/soalujian', [SoalController::class, 'getSoal']);

  //get matkul
  Route::get('/matkul_dosen', [MatkulController::class, 'getMatkulbyDosen']);

  //soal pg
  Route::post('/addsoalPG', [PgController::class, 'addSoalPG']);
  Route::get('/listSoalPG', [PgController::class, 'getSoalByDosen']);
  Route::get('/detailSoal/{id}', [PgController::class, 'getDetailSoal']);
  Route::delete('/deletesoal/{id}', [PgController::class, 'deleteSoal']);
  Route::post('/updatesoal/{id}', [PgController::class, 'updateSoal']);
  
  //list ujian
  Route::post('/ujian', [UjiansController::class, 'postData']);
  Route::get('/listujian', [UjiansController::class, 'getUjianbyDosen']);
  Route::put('/updateujian/{id}', [UjiansController::class, 'updateUjianByDosen']);
  Route::delete('/deleteujian/{id}', [UjiansController::class, 'deleteUjianByDosen']);
  Route::get('/countSoalUjian', [UjiansController::class, 'getJumlahUjian']);

  //hasil ujian
  Route::get('/hasilujian', [HasilController::class, 'getHasilUjian']);
  Route::get('/hasilujiandosen/{id}', [HasilController::class, 'getHasilUjianbyDosen']);
  Route::put('/edithasilujian/{id}', [HasilController::class, 'editHasilUjian']);
  Route::delete('/deletehasilujian/{id}', [HasilController::class, 'deleteHasilUjian']);
  
});
Route::post('/loginDosen', [DosenController::class, 'loginDosen']);
Route::post('/addAdmin', [DosenController::class, 'addAdmin']);


//route matkul 
//route api ujian


Route::group(['middleware' => 'ujian_auth'], function() {
  Route::get('/ujian', [UjiansController::class, 'getData']);
  Route::get('/ujian_detail', [UjiansController::class, 'getUJianDetail']);
  Route::get('/soalessay', [SoalController::class, 'getSoalbyId']);
  Route::get('/soalPG', [PgController::class, 'getSoalPG']);
  Route::get('/soalUjianPg', [PgController::class, 'getSoalUjian']);
  
  Route::post('/posthasilujian', [HasilController::class, 'postHasilUjian']);
});
Route::post('/loginujian', [UjiansController::class, 'loginUjian']);