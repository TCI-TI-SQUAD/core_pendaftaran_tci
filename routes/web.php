<?php

use Illuminate\Support\Facades\Route;

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

// LANDING PAGE
    Route::get('/','landingpage\LandingPageController@index')->name('user.landing-page');
    Route::get('/test',function(){
        return view('user-dashboard.user-kelas-saya.user-kelas-beranda');
    })->name('user.kelas.saya');
// AKHIR

// ABOUT PAGE
    Route::get('/about',function(){
        return view('user-landing-page.about-page');
    })->name('user.about-page');
// AKHIR



// USER
    Route::prefix('user')->group(function(){
        // USER AUTH
            Route::get('login','auth\authcotroller\AuthController@index')->name('user.login');

            Route::get('register', 'auth\authcotroller\AuthController@register')->name('user.register');

            Route::post('login','auth\authcotroller\AuthController@loginPost')->name('user.post.login');

            Route::post('register','auth\authcotroller\AuthController@registerPost')->name('user.post.register');

            Route::post('logout','auth\authcotroller\AuthController@logout')->name('user.post.logout');

            // AJAX
                // AJAX GET FAKULTAS
                    Route::post('/getfakultas','auth\authcotroller\AuthController@getFakultas')->name('user.ajax.getFakultas');
                // END

                // AJAX GET PRODI
                    Route::post('/getprodi','auth\authcotroller\AuthController@getProdi')->name('user.ajax.getProdi');
                // END

                // AJAX GET SEKOLAH
                    Route::post('/getsekolah','auth\authcotroller\AuthController@getSekolah')->name('user.ajax.getSekolah');
                // END
            // END

        // AKHIR

        // AUTH MIDDLEWARE
            Route::middleware('auth')->group(function(){
                // USER DASHBOARD
                    Route::get('/beranda','usercontroller\UserHomeController@index')->name('user.dashboard');
                // AKHIR

                // USER PENDAFTARAN
                    Route::get('/pendaftaran/{nama?}','usercontroller\pendaftaran\UserPendaftaranController@index')->name('user.pendaftaran');

                    Route::get('/jadwalkelas/{id_kelas}','usercontroller\pendaftaran\JadwalKelasController@index')->name('user.jadwal.kelas');

                    Route::post('/daftarkelas','usercontroller\pendaftaran\DaftarKelasController@index')->name('user.daftar.kelas');
                // AKHIR

                // USER KELAS
                    Route::get('/kelassaya/{filter?}','usercontroller\kelas\UserKelasSayaController@index')->name('user.kelas.saya');

                    Route::get('/kelas/beranda/{id_detail_kelas}','usercontroller\kelas\UserKelasSayaController@kelasBeranda')->name('user.kelas.beranda');

                    Route::get('/kelas/pembayaran/{id_kelas}','usercontroller\kelas\UserPembayaranKelasController@stepPembayaran')->name('user.pembayaran.kelas');

                    Route::get('/kelas/upload/{id_kelas}','usercontroller\kelas\UserPembayaranKelasController@stepUploadBukti')->name('user.upload.kelas');
                    
                    Route::put('/kelas/upload','usercontroller\kelas\UserPembayaranKelasController@postBuktiPembayaran')->name('user.upload.bukti');

                    Route::get('/kelas/verifikasi/{id_detail_kelas}','usercontroller\kelas\UserPembayaranKelasController@stepVerifikasi')->name('user.verifikasi.kelas');
                // AKHIR
            });
        // END
    });
// AKHIR



