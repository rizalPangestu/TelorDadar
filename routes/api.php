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


//route api dosen
Route::get('/dosen', [DosenController::class, 'getData']);
Route::post('/dosen', [DosenController::class, 'postData']);
Route::post('/loginDosen', [DosenController::class, 'loginDosen']);


//route matkul 
Route::get('/matkul', [MatkulController::class, 'getMatkul']);
Route::post('/matkul', [MatkulController::class, 'addMatkul']);
//route api ujian
Route::post('/ujian', [UjiansController::class, 'postData']);

Route::get('/soalujian', [SoalController::class, 'getSoal']);
Route::post('/soalujian', [SoalController::class, 'addSoal']);
Route::post('/soalessay', [SoalController::class, 'getSoalbyId']);

Route::group(['middleware' => 'ujian_auth'], function() {
  Route::get('/ujian', [UjiansController::class, 'getData']);
  Route::get('/ujian_detail', [UjiansController::class, 'getUJianDetail']);
});
Route::post('/loginujian', [UjiansController::class, 'loginUjian']);