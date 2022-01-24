<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserAtAdminController;
use App\Http\Controllers\DesainController;
use App\Http\Controllers\RenovasiController;
use App\Http\Controllers\ProfilController;

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
    return view('login');
})->name('login');
//Auth::routes(['verify' => true]);
Route::post('/validate',[AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'logout'])->name('auth.logout');
Route::post('/register-store', [AuthController::class, 'register'])->name('auth.register');

Route::get('/register', function () {
    return view('register');
});

Route::group(['middleware' => ['auth']], function(){
    Route::post('/change-password-update', [AuthController::class, 'change_password'])->name('auth.change-password-update');
    Route::post('/change-password-updates/{id}', [AuthController::class, 'change_passwords'])->name('auth.change-password-updates');
    Route::get('/change-password', [AuthController::class, 'change_password_create'])->name('auth.change-password');
});

Route::group(['middleware' => ['auth','cekrole:User,Admin']], function(){
    Route::resource('user', UserController::class); //ada user index

    Route::get('/company-profile', [UserController::class, 'company_profile'])->name('user.company-profile');

    Route::get('/design', [UserController::class, 'design_index'])->name('user.design');

    Route::get('/renovasi-user', [UserController::class, 'renovasi'])->name('user.renovasi');

    Route::get('/done-confirm', [UserController::class, 'done_confirm'])->name('user.done-confirm');

    Route::post('/store-to-kart', [UserController::class, 'store_item_to_kart'])->name('user.store-to-kart');

    Route::post('/store-pemesanan-renovasi', [UserController::class, 'store_pemesanan_renovasi'])->name('user.store-pemesanan-renovasi');

    Route::get('/detail-design/{id}', [UserController::class, 'detail_design'])->name('user.detail-design');

    Route::post('/destroy-cart/{id}', [UserController::class, 'destroy_cart_item'])->name('user.destroy-cart');

    Route::get('/detail-item-renovasi/{id}', [UserController::class, 'detail_item_renovasi'])->name('user.detail-item-renovasi');

    Route::get('/media-user', [UserController::class, 'media'])->name('user.media');

    Route::get('/informasi-user', [UserController::class, 'informasi'])->name('user.informasi');
    
    Route::post('/upload-revisi', [UserController::class, 'upload_revisi'])->name('user.upload-revisi');
    
    Route::get('/hapus-revisi/{revisi_id}', [UserController::class, 'hapus_revisi'])->name('user.delete-revisi');

    Route::get('/get-pesanan-user', [UserController::class, 'get_pesanan'])->name('user.get-pesanan');

    Route::get('/get-kart-item', [UserController::class, 'get_kart_item'])->name('user.get-kart-item');

    Route::get('/get-pesanan-renovasi', [UserController::class, 'get_pesanan_renovasi'])->name('user.get-pesanan-renovasi');

    Route::get('/get-progress-renovasi', [UserController::class, 'get_progress_renovasi'])->name('user.get-progress-renovasi');
    
    Route::get('/download-pembayaran-renovasi', [UserController::class, 'download_pembayaran_renovasi'])->name('pembayaran.download-pdf-renovasi');

    Route::get('/download-pembayaran-desain', [UserController::class, 'download_pembayaran_desain'])->name('pembayaran.download-pdf-desain');
});

Route::group(['middleware' => ['auth','cekrole:Admin']], function(){
    

    Route::get('/confirm/{id}', [PesananController::class, 'confirm'])->name('pesanan.confirm');
    Route::get('/confirm-renovasi/{id}', [PesananController::class, 'confirm_renovasi'])->name('pesanan.confirm-renovasi');
    Route::post('/reject-renovasi/{id}', [PesananController::class, 'reject_renovasi'])->name('pesanan.reject-renovasi');

    Route::resource('profil', ProfilController::class);
    Route::post('/visi-store', [ProfilController::class, 'visi_store'])->name('profil.visi-store');
    Route::post('/misi-store', [ProfilController::class, 'misi_store'])->name('profil.misi-store');
    Route::get('/get-visi', [ProfilController::class, 'get_visi'])->name('profil.get-visi');
    Route::get('/get-misi', [ProfilController::class, 'get_misi'])->name('profil.get-misi');
    Route::post('/visi-update/{id}', [ProfilController::class, 'visi_update'])->name('profil.visi-update');
    Route::post('/visi-destroy/{id}', [ProfilController::class, 'visi_destroy'])->name('profil.visi-destroy');
    Route::post('/misi-update/{id}', [ProfilController::class, 'misi_update'])->name('profil.misi-update');
    Route::post('/misi-destroy/{id}', [ProfilController::class, 'misi_destroy'])->name('profil.misi-destroy');

    Route::resource('media', MediaController::class);
    Route::get('/get-media', [MediaController::class, 'get_media'])->name('media.get-media');
    Route::get('/all-media', [MediaController::class, 'all_media'])->name('media.all-media');

    Route::resource('informasi', InformasiController::class);
    Route::get('/get-info', [InformasiController::class, 'get_info'])->name('informasi.get-info');

    Route::resource('user-admin', UserAtAdminController::class);
    Route::get('/get-user', [UserAtAdminController::class, 'get_user'])->name('user-admin.get-user');
    Route::get('/get-arsitek', [UserAtAdminController::class, 'get_arsitek'])->name('user-admin.get-arsitek');
    Route::get('/get-renovator', [UserAtAdminController::class, 'get_renovator'])->name('user-admin.get-renovator');

    
    Route::post('/register-arsitek-store', [AuthController::class, 'register_arsitek'])->name('auth.register-arsitek');
    Route::post('/register-renovator-store', [AuthController::class, 'register_renovator'])->name('auth.register-renovator');
});

Route::group(['middleware' => ['auth','cekrole:Admin,Arsitek']], function(){
    
    Route::get('/done-revisi/{revisi_id}', [UserController::class, 'done_revisi'])->name('user.done-revisi');

    Route::resource('pesanan', PesananController::class);
    Route::get('/get-pesanan', [PesananController::class, 'get_pesanan'])->name('pesanan.get-pesanan');
    Route::get('/confirm/{id}', [PesananController::class, 'confirm'])->name('pesanan.confirm');
    Route::get('/done/{id}', [PesananController::class, 'done'])->name('pesanan.done');
    Route::get('/to-tahap-dua/{id}', [PesananController::class, 'to_tahap_dua'])->name('pesanan.to-tahap-dua');
    Route::get('/to-tahap-tiga/{id}', [PesananController::class, 'to_tahap_tiga'])->name('pesanan.to-tahap-tiga');
    Route::post('/store-progress/{id}', [PesananController::class, 'store_progress'])->name('pesanan.store-progress');

    Route::resource('desain', DesainController::class);
    Route::get('/get-desain', [DesainController::class, 'get_desain'])->name('desain.get-desain');
    Route::get('/get-gambar-desain/{id}', [DesainController::class, 'get_gambar_desain'])->name('desain.get-gambar-desain');
    
    Route::resource('renovasi', RenovasiController::class);
    Route::get('/get-renovasi', [RenovasiController::class, 'get_renovasi'])->name('renovasi.get-renovasi');
    Route::get('/get-gambar-renovasi/{id}', [RenovasiController::class, 'get_gambar_renovasi'])->name('renovasi.get-gambar-renovasi');
});

Route::group(['middleware' => ['auth','cekrole:Admin,Renovator']], function(){
    Route::get('/pesanan-renovasi', [PesananController::class, 'index_renovasi'])->name('pesanan.index-renovasi');
    Route::get('/get-pesanan-renovasi-admin', [PesananController::class, 'get_pesanan_renovasi'])->name('pesanan.get-pesanan-renovasi');
    Route::get('/done-renovasi/{id}', [PesananController::class, 'done_renovasi'])->name('pesanan.done-renovasi');
    Route::post('/store-progress-renovasi/{id}', [PesananController::class, 'store_progress'])->name('pesanan.store-progress-renovasi');
});
