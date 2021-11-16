<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FirebaseController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('cobo', function(){
    return view('cobo');
});

Route::get('tugas', function(){
    return view('tugas');
});



Route::get('siswa','App\Http\Controllers\SiswaController@index');
Route::get('ulang','App\Http\Controllers\SiswaController@ulang');
Route::get('login-otp', [FirebaseController::class, 'index']);
