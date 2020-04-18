<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('register', 'PetugasController@register');
Route::post('login', 'PetugasController@login');
Route::get('/', function(){
    return Auth::user()->level;
})->middleware('jwt.verify');

Route::get('user', 'PetugasController@getAuthenticatedUser')->middleware('jwt.verify');

#pelanggan
Route::post('/simpan_pelanggan', 'PelangganController@store')->middleware('jwt.verify');
Route::put('/ubah_pelanggan/{id}', 'PelangganController@update')->middleware('jwt.verify');
Route::get('/tampil_pelanggan', 'PelangganController@tampil')->middleware('jwt.verify');
Route::get('/index_pelanggan/{id}', 'PelangganController@index')->middleware('jwt.verify');
Route::delete('/hapus_pelanggan/{id}', 'PelangganController@destroy')->middleware('jwt.verify');

#jenis mobil
Route::post('/simpan_jenis', 'JenisController@store')->middleware('jwt.verify');
Route::put('/ubah_jenis/{id}', 'JenisController@update')->middleware('jwt.verify');
Route::get('/tampil_jenis', 'JenisController@tampil')->middleware('jwt.verify');
Route::get('/index_jenis/{id}', 'JenisController@index')->middleware('jwt.verify');
Route::delete('/hapus_jenis/{id}', 'JenisController@destroy')->middleware('jwt.verify');

#mobil
Route::post('/simpan_mobil', 'MobilController@store')->middleware('jwt.verify');
Route::put('/ubah_mobil/{id}', 'MobilController@update')->middleware('jwt.verify');
Route::get('/tampil_mobil', 'MobilController@tampil')->middleware('jwt.verify');
Route::get('/index_mobil/{id}', 'MobilController@index')->middleware('jwt.verify');
Route::delete('/hapus_mobil/{id}', 'MobilController@destroy')->middleware('jwt.verify');