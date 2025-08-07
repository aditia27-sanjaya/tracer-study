<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\AlumniController;

Route::get('/',[FrontendController::class, 'index'])->name('/');
Route::get('/auth',[FrontendController::class, 'login'])->name('/auth');
Route::get('/logadmin',[AuthController::class, 'index'])->name('/logadmin');
Route::post('/loginAct',[AuthController::class, 'loginAct'])->name('/loginAct');

Route::post('/loginPost',[AlumniController::class, 'loginPost'])->name('/loginPost');
Route::get('/regist',[AlumniController::class, 'regist'])->name('/regist');
Route::post('/registPost',[AlumniController::class, 'registPost'])->name('/registPost');


// Session Pimpinan
Route::group(['middleware' => ['cekSession:1', 'no_cache']], function () {
Route::get('/pimpinan/dashboard',[AdminController::class, 'index'])->name('pimpinan/dashboard');
// Jadwal
Route::get('/pimpinan/set-jadwal',[AdminController::class, 'jadwal'])->name('pimpinan/set-jadwal');
Route::post('/pimpinan/addJadwal',[AdminController::class, 'addJadwal'])->name('pimpinan/addJadwal');
Route::post('/pimpinan/editJadwal',[AdminController::class, 'editJadwal'])->name('pimpinan/editJadwal');
Route::post('/pimpinan/deleteJadwal',[AdminController::class, 'deleteJadwal'])->name('pimpinan/deleteJadwal');
// Kuisioner
Route::get('/pimpinan/kuisioner',[AdminController::class, 'kuisioner'])->name('pimpinan/kuisioner');
Route::post('/pimpinan/addKuisioner',[AdminController::class, 'addKuisioner'])->name('pimpinan/addKuisioner');
Route::post('/pimpinan/editKuisioner',[AdminController::class, 'editKuisioner'])->name('pimpinan/editKuisioner');
Route::post('/pimpinan/deleteKuisioner',[AdminController::class, 'deleteKuisioner'])->name('pimpinan/deleteKuisioner');
Route::post('/pimpinan/aksiPilihanGanda',[AdminController::class, 'aksiPilihanGanda'])->name('pimpinan/aksiPilihanGanda');
Route::post('/pimpinan/editPilihan',[AdminController::class, 'editPilihan'])->name('pimpinan/editPilihan');
Route::get('/pimpinan/deletePilihan/{id}',[AdminController::class, 'deletePilihan'])->name('pimpinan/deletePilihan/{id}');
// User Admin
Route::get('/pimpinan/user',[AdminController::class, 'AkunAdmin'])->name('pimpinan/user');
Route::post('/pimpinan/tambahAdmin',[AdminController::class, 'addAdmin'])->name('pimpinan/tambahAdmin');
Route::post('/pimpinan/editAdmin',[AdminController::class, 'updateAdmin'])->name('pimpinan/editAdmin');
Route::post('/pimpinan/deleteAdmin',[AdminController::class, 'deleteAdmin'])->name('pimpinan/deleteAdmin');
// Alumni
Route::get('/pimpinan/alumni',[AdminController::class, 'AkunAlumni'])->name('pimpinan/alumni');
// Password
Route::get('pimpinan/ganti-password',[AdminController::class, 'passForm'])->name('pimpinan/ganti-password');
Route::post('pimpinan/passUpdate',[AdminController::class, 'passUpdate'])->name('pimpinan/passUpdate');
// Logout
Route::get('/logout',[AuthController::class, 'Logout'])->name('/');
});


// Session User Admin
Route::group(['middleware' => ['cekSession:2', 'no_cache']], function () {
Route::get('/user/dashboard',[UserController::class, 'index'])->name('user/dashboard');
// Jadwal
Route::get('/user/set-jadwal',[UserController::class, 'jadwal'])->name('user/set-jadwal');
Route::post('/user/addJadwal',[UserController::class, 'addJadwal'])->name('user/addJadwal');
Route::post('/user/editJadwal',[UserController::class, 'editJadwal'])->name('user/editJadwal');
Route::post('/user/deleteJadwal',[UserController::class, 'deleteJadwal'])->name('user/deleteJadwal');
// Kuisioner
Route::get('/user/kuisioner',[UserController::class, 'kuisioner'])->name('user/kuisioner');
Route::post('/user/addKuisioner',[UserController::class, 'addKuisioner'])->name('user/addKuisioner');
Route::post('/user/editKuisioner',[UserController::class, 'editKuisioner'])->name('user/editKuisioner');
Route::post('/user/deleteKuisioner',[UserController::class, 'deleteKuisioner'])->name('user/deleteKuisioner');
Route::post('/user/aksiPilihanGanda',[UserController::class, 'aksiPilihanGanda'])->name('user/aksiPilihanGanda');
Route::post('/user/editPilihan',[UserController::class, 'editPilihan'])->name('user/editPilihan');
Route::get('/user/deletePilihan/{id}',[UserController::class, 'deletePilihan'])->name('user/deletePilihan/{id}');
// Alumni
Route::get('/user/alumni',[UserController::class, 'AkunAlumni'])->name('user/alumni');
// Password
Route::get('user/ganti-password',[UserController::class, 'passForm'])->name('user/ganti-password');
Route::post('user/passUpdate',[UserController::class, 'passUpdate'])->name('user/passUpdate');
// Logout
Route::get('/logout',[AuthController::class, 'logout'])->name('/');
});


// Session Alumni
Route::group(['middleware' => ['cekSession:3', 'no_cache']], function () {
Route::get('/alumni/dashboard',[AlumniController::class, 'index'])->name('alumni/dashboard');
// Profil
Route::get('/alumni/profil',[AlumniController::class, 'profil'])->name('alumni/profil');
Route::post('/alumni/profilUpdate',[AlumniController::class, 'profilUpdate'])->name('alumni/profilUpdate');
// Kuisioner
Route::get('/alumni/kuisioner',[AlumniController::class, 'kuisioner'])->name('alumni/kuisioner');
Route::post('/alumni/jawaban',[AlumniController::class, 'jawaban'])->name('alumni/jawaban');
// Password
Route::get('alumni/password',[UserController::class, 'passForm'])->name('alumni/password');

Route::get('/logout',[AuthController::class, 'logout'])->name('logout');
});
