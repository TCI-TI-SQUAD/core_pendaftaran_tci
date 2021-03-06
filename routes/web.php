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

                    // TRASHED SISWA
                        Route::get('trashed/siswa','admin\siswa\AdminSiswaTrashedController@index')->name('admin.trashed.siswa.index');

                        Route::put('trashed/restore/siswa','admin\siswa\AdminSiswaTrashedController@restoreTrashedSiswa')->name('admin.trashed.siswa.restore');
                        
                        // AJAX TRASHED SISWA
                            Route::post('trashedsiswadata','admin\siswa\AdminSiswaTrashedController@ajaxTrashedSiswaData')->name('admin.ajax.trashed.siswa');
                        // END
                    // END

                    // AJAX SISWA
                        Route::post('siswadata','admin\siswa\AdminSiswaController@ajaxDataSiswa')->name('admin.ajax.siswa');
                    // END
                // END

                // PENGUMUMAN SISTEM
                    Route::get('pengumumansistem','admin\pengumuman_sistem\AdminPengumumanSistemController@index')->name('admin.pengumuman.sistem');

                    Route::get('create/pengumumansistem','admin\pengumuman_sistem\AdminPengumumanSistemController@createPengumumanSistem')->name('admin.create.pengumuman.sistem');

                    Route::post('create/pengumumansistem','admin\pengumuman_sistem\AdminPengumumanSistemController@storeCreatePengumumanSistem')->name('admin.store.create.pengumuman.sistem');

                    Route::delete('delete/pengumumansistem','admin\pengumuman_sistem\AdminPengumumanSistemController@deletePengumumanSistem')->name('admin.delete.pengumuman.sistem');

                    // AJAX PENGUMUMAN SISTEM
                        Route::post('pengumumansistemdata','admin\pengumuman_sistem\AdminPengumumanSistemController@ajaxPengumumumanSistemData')->name('admin.ajax.pengumuman.sistem');
                    // END
                // END

                // PENDAFTARAN KELAS
                    
                    Route::get('pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@index')->name('admin.pendaftarankelas');

                    Route::get('create/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@createPendaftaranKelas')->name('admin.create.pendaftarankelas');
                    Route::post('create/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@storeCreatePendaftaranKelas')->name('admin.post.create.pendaftarankelas');

                    Route::get('detail/pendaftarankelas/{id?}','admin\pendaftaran_kelas\AdminPendaftaranKelasController@detailPendaftaranKelas')->name('admin.detail.pendaftarankelas');

                    Route::get('edit/pendaftarankelas/{id?}','admin\pendaftaran_kelas\AdminPendaftaranKelasController@editPendaftaranKelas')->name('admin.edit.pendaftarankelas');
                    Route::put('edit/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@storeEditPendaftaranKelas')->name('admin.store.edit.pendaftarankelas');

                    Route::delete('delete/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@deletePendaftaranKelas')->name('admin.delete.pendaftarankelas');

                    // TRASHED PENDAFTARAN
                        Route::get('trashed/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@indexTrashedPendaftaranKelas')->name('admin.trashed.pendaftarankelas');

                        Route::put('restore/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@restorePendaftaranKelas')->name('admin.restore.pendaftarankelas');

                        // AJAX TRASEHD PENDAFTARAN
                            Route::post('trashedpendaftarankelasdata','admin\pendaftaran_kelas\AdminPendaftaranKelasController@ajaxTrashedPendaftaranKelas')->name('admin.ajax.trashed.pendaftarankelas');
                        // END
                    // END

                    // ARCHIVED PENDAFTARAN
                        Route::get("archived/pendaftarankelas",'admin\pendaftaran_kelas\AdminPendaftaranKelasController@indexArchivedPendaftaranKelas')->name('admin.index.archived.pendaftarankelas');

                        Route::put('archive/pendaftarankelas','admin\pendaftaran_kelas\AdminPendaftaranKelasController@archivedPendaftaranKelas')->name('admin.archived.pendaftarankelas');

                        Route::put("unarchived/pendaftarankelas",'admin\pendaftaran_kelas\AdminPendaftaranKelasController@unArchivedPendaftaranKelas')->name('admin.unarchived.pendaftarankelas');

                        // AJAX ARCHIVED PENDAFTARAN
                            Route::post("archivedpendaftarankelasdata",'admin\pendaftaran_kelas\AdminPendaftaranKelasController@ajaxArchivedPendaftaranData')->name('admin.ajax.archived.pendaftarankelas');
                        // END
                    // END

                    // PENGUMUMAN PENDAFTARAN
                        Route::get('pengumuman/pendaftarankelas/{id?}','admin\pendaftaran_kelas\AdminPengumumanPendaftaranKelasController@index')->name('admin.index.pengumuman.pendaftarankelas');

                        Route::get('create/pengumuman/pendaftarankelas/{id?}','admin\pendaftaran_kelas\AdminPengumumanPendaftaranKelasController@createPengumumanPendaftaranKelas')->name('admin.create.pengumuman.pendaftarankelas');

                        Route::post('create/pengumumman/pendaftaran','admin\pendaftaran_kelas\AdminPengumumanPendaftaranKelasController@postCreatePengumumanPendaftaranKelas')->name('admin.post.create.pengumuman.pendaftarankelas');

                        Route::delete('delete/pengumuman/pendaftarankelas','admin\pendaftaran_kelas\AdminPengumumanPendaftaranKelasController@deletePengumumanPendaftaranKelas')->name('admin.delete.pengumuman.pendaftarankelas');

                        // AJAX
                            Route::post('pengumumanpendaftarankelasdata','admin\pendaftaran_kelas\AdminPengumumanPendaftaranKelasController@ajaxPengumumanPendaftaranKelas')->name('admin.ajax.pengumuman.pendaftarankelas');
                        // END
                    // END

                    // KELAS
                        Route::get('kelas/pendaftarankelas/{id?}','admin\pendaftaran_kelas\kelas\AdminKelasController@index')->name('admin.kelas');

                        Route::get('detail/kelas/{id?}','admin\pendaftaran_kelas\kelas\AdminKelasController@detailKelas')->name('admin.detail.kelas');

                        Route::get('edit/kelas/{id?}','admin\pendaftaran_kelas\kelas\AdminKelasController@editKelas')->name('admin.edit.kelas');
                        Route::put('edit/kelas','admin\pendaftaran_kelas\kelas\AdminKelasController@storeEditKelas')->name('admin.store.edit.kelas');

                        Route::get('create/kelas/pendaftarankelas/{id?}','admin\pendaftaran_kelas\kelas\AdminKelasController@createKelas')->name('admin.create.kelas');
                        Route::post('create/kelas/pendaftarankelas','admin\pendaftaran_kelas\kelas\AdminKelasController@postCreateKelas')->name('admin.post.create.kelas');

                        Route::delete('delete/kelas','admin\pendaftaran_kelas\kelas\AdminKelasController@deleteKelas')->name('admin.delete.kelas');

                        // TRASHED KELAS
                            Route::get('trashed/kelas/pendaftarankelas/{id?}','admin\pendaftaran_kelas\kelas\AdminKelasController@indexTrashedKelas')->name('admin.trashed.kelas');

                            Route::put('restore/kelas/pendaftarankelas','admin\pendaftaran_kelas\kelas\AdminKelasController@restoreTrashedKelas')->name('admin.restore.trashed.kelas');

                            // AJAX
                                Route::post('trashedKelasData','admin\pendaftaran_kelas\kelas\AdminKelasController@ajaxTrashedKelasData')->name('admin.ajax.trashed.kelas');
                            // END
                        // END

                        // PESERTA KELAS
                            Route::get('pesertakelas/kelas/{id?}','admin\pendaftaran_kelas\kelas\peserta_kelas\PesertaKelasController@index')->name('admin.peserta.kelas.index');

                            // AJAX
                                Route::post('pesertakelasdata','admin\pendaftaran_kelas\kelas\peserta_kelas\PesertaKelasController@ajaxPesertaKelasData')->name('admin.ajax.peserta.kelas.index');
                            // END
                        // END

                        // AJAX
                            Route::post('kelasdata','admin\pendaftaran_kelas\kelas\AdminKelasController@ajaxKelasData')->name('admin.ajax.kelas');
                        // END
                    // END

                    // AJAX
                        Route::post('pendaftarandata','admin\pendaftaran_kelas\AdminPendaftaranKelasController@ajaxPendaftaranData')->name('admin.ajax.pendaftarandata');
                    // END

                // END

                // LOGOUT ADMIN
                    Route::post('logout','admin\auth\AdminAuthController@postLogout')->name('admin.logout');
                // END
            });
        // END
    });
// AKHIR



