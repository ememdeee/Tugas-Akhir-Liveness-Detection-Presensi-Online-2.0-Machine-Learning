<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Dashboard2Controller;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\AbsenController;
use App\Http\Controllers\FacedetectionController;
use App\Http\Controllers\Livenessdetection;
use App\Http\Controllers\LivenessdetectionUi;
use App\Http\Controllers\DeteksiEkspresi;
use App\Http\Controllers\DeteksiObjek;
use App\Http\Controllers\PengenalanWajah;

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

//ini aawal route dari chesa, kalau ada apa apa balik ke sini karena semua aman sampe console log
Route::get('/chesa', function () {
    return view('welcome');
});
//sampe sini

Route::get('/', function () {
    return view('about.index');
});

//halaman utama ('/') adalah tempat absen, kalau belom login diarahkan ke about aja
//mulai buat lagi route absen, jadi home nya akan berisni info tentang girisa aja
Route::get('/absen', [AbsenController::class, 'index'])->middleware('auth');
Route::post('/absen', [AbsenController::class, 'submitabsen'])->middleware('auth');

// Route::get('/register', function () {
//     return view('register');
// });

// Route::get('/login', function () {
//     return view('login');
// });

Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);


Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);
// Auth::routes();

// Route::get('/home', 'HomeController@index')->name('home');

Route::get('/about', [AboutController::class, 'index']);

//halaman dashboard untuk mlihat hasil absen

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth','role:admin']);
Route::post('/dashboard', [DashboardController::class, 'pilihTanggal'])->middleware(['auth','role:admin']);
Route::get('/dashboard2', [Dashboard2Controller::class, 'index'])->middleware(['auth','role:admin']);
Route::post('/dashboard2', [Dashboard2Controller::class, 'pilihUser'])->middleware(['auth','role:admin']);


Route::get('/facedetection', [FacedetectionController::class, 'index']);

//upload ke git hub atau update
// git add .
// git commit -m "First commit"
// git push



//halaman liveness detection


Route::get('/livenessdetection', [Livenessdetection::class, 'index']);
Route::post('/livenessdetection', [Livenessdetection::class, 'cekdatadiri']);
Route::get('/livenessdetectionUi', [LivenessdetectionUi::class, 'index']);


// pengujian purpose
Route::get('/deteksiekspresi', [DeteksiEkspresi::class, 'index']);
Route::get('/deteksiobjek', [DeteksiObjek::class, 'index']);
Route::get('/pengenalanwajah', [PengenalanWajah::class, 'index']);
