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
    Route::get('/admin',function(){
        return view('admin.email.email_user.email-user');
    });
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
            Route::middleware(['auth','user.middleware'])->group(function(){
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

                    Route::get('/kelas/fail/{id_detail_kelas}','usercontroller\kelas\UserPembayaranKelasController@stepFail')->name('user.fail.kelas');
                // AKHIR

                // USER PROFILE
                    Route::get('/profile','usercontroller\profile\UserProfileController@index')->name('user.profile.index');

                    Route::get('/profile/edit','usercontroller\profile\UserProfileController@edit')->name('user.profile.edit');

                    Route::put('/profile/store','usercontroller\profile\UserProfileController@store')->name('user.profile.store');
                // END

                // USER NOTIFICATION
                    Route::get('notification/{filter?}','usercontroller\notification\UserNotificationController@index')->name('user.notification.index');
                // END
            });
        // END
    });
// AKHIR

// ADMIN
    Route::prefix('admin')->group(function(){
        // ADMIN AUTH
            Route::get('login','admin\auth\AdminAuthController@LoginIndex')->name('admin.auth.login');
            Route::post('login','admin\auth\AdminAuthController@postLogin')->name('admin.auth.login.post');
        // END

        // ADMIN MIDDLEWARE
            Route::middleware('admin.middleware')->group(function(){
                Route::get('dashboard','admin\dashboard\AdminDashboardController@index')->name('admin.dashboard');
                
                // SISWA
                    Route::get('siswa','admin\siswa\AdminSiswaController@index')->name('admin.siswa');
                    Route::get('detail/siswa/{id?}','admin\siswa\AdminSiswaController@detailSiswa')->name('admin.detail.siswa');
                    
                    Route::get('create/siswa','admin\siswa\AdminSiswaController@createSiswa')->name('admin.create.siswa');
                    Route::post('create/siswa','admin\siswa\AdminSiswaController@storeCreateSiswa')->name('admin.store.create.siswa');
                    
                    Route::get('edit/siswa/{id?}','admin\siswa\AdminSiswaController@editSiswa')->name('admin.edit.siswa');
                    Route::put('edit/siswa/{id?}','admin\siswa\AdminSiswaController@storeSiswa')->name('admin.store.siswa');
                    
                    Route::delete('delete/siswa','admin\siswa\AdminSiswaController@deleteSiswa')->name('admin.delete.siswa');

                    // NOTIFIKASI
                        Route::get('notifikasi/siswa/{id}','admin\siswa\AdminSiswaNotifikasiController@index')->name('admin.notifikasi.siswa.index');
                        
                        Route::get('create/notifikasi/siswa/{id}','admin\siswa\AdminSiswaNotifikasiController@createNotifikasiSiswa')->name('admin.notifikasi.siswa.create');
                        Route::post('store/notifikasi/siswa','admin\siswa\AdminSiswaNotifikasiController@storeNotifikasiSiswa')->name('admin.notifikasi.siswa.store');
                        
                        Route::get('update/notifikasi/siswa/{id_notifikasi}','admin\siswa\AdminSiswaNotifikasiController@updateNotifikasiSiswa')->name('admin.notifikasi.siswa.update');
                        Route::put('update/notifikasi/siswa','admin\siswa\AdminSiswaNotifikasiController@storeUpdateNotifikasiSiswa')->name('admin.notifikasi.siswa.store.update');
                        
                        Route::delete('delete/notifikasisiswa','admin\siswa\AdminSiswaNotifikasiController@deleteNotifikasiSiswa')->name('admin.notifikasi.siswa.delete');

                        // AJAX NOTIFIKASI SISWA
                            Route::post('siswanotifikasidata','admin\siswa\AdminSiswaNotifikasiController@ajaxDataNotifikasiSiswa')->name('admin.ajax.notifikasi.siswa');
                        // END
                    // END

                    // EMAIL
                        Route::get('email/siswa/{id}','admin\siswa\AdminSiswaEmailController@index')->name('admin.email.siswa.index');

                        Route::get('create/email/siswa/{id}','admin\siswa\AdminSiswaEmailController@createEmailSiswa')->name('admin.email.siswa.create');
                        Route::post('store/email/siswa','admin\siswa\AdminSiswaEmailController@storeEmailSiswa')->name('admin.email.siswa.store');
                        
                        // AJAX EMAIL
                            Route::post('siswaemaildata','admin\siswa\AdminSiswaEmailController@ajaxSiswaEmailData')->name('admin.ajax.email.siswa');
                        // END
                    // END


                    // AJAX SISWA
                        Route::post('siswadata','admin\siswa\AdminSiswaController@ajaxDataSiswa')->name('admin.ajax.siswa');
                    // END
                // END
                

                // LOGOUT ADMIN
                    Route::post('logout','admin\auth\AdminAuthController@postLogout')->name('admin.logout');
                // END
            });
        // END
    });
// AKHIR



