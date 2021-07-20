<?php

namespace App\Http\Controllers\usercontroller\pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

use App\PengaturanSistem;
use App\Kelas;
use App\User;
use DB;

class DaftarKelasController extends Controller
{
    public function index(Request $request){
        /**
         * PREREQUISIT
         * 
         * HIGH :
         * 
         * 1. KELAS HARUS DALAM STATUS BUKA, DAN MENGALAMI SOFT DELETE SERTA ID ADA DI DATABASE
         * 2. PENDAFTARAN KELAS MASIH AKTIF DAN BELUM CUT OFF
         * 3. KUOTA KELAS TELAH PENUH MAKA TIDAK DAPAT DILANJUTKAN
         * 4. APABILA KELAS TELAH DIMULAI MAKAN TIDAK DAPAT DILANJUTKAN
         * 5. ID KELAS HARUS ADA DI TABLE KELAS
         * 6. APABILA USER TELAH MENDAFTARA PADA KELAS LAIN
         * 
         * RETURN >>> ERROR KALAU KEPERLUAN DI ATAS TIDAK TERPENUHI
         * 
         * LOW :
         * 
         * 1. APABILA PENGAJAR BELUM ADA TIDAK APA - APA
         * 2. APABILA JADWAL MASIH KOSONG TIDAK APA - APA
         * 
         * RETURN >>> DAPAT MENDAFTAR
         */

    // PENGATURAN SISTEM
        try{
            $pengaturan_sistem = PengaturanSistem::where('nama_pengaturan','open_pendaftaran')->firstOrFail()->status;
        }catch(ModelNotFoundException $err){
            $pengaturan_sistem = false;
        }

        if(!$pengaturan_sistem){
            return redirect()->back()->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Pendaftaran Kelas Ditutup',
                'message' => 'Pendaftaran ke dalam semua kelas sedang ditutup admin, apabila diperlukan silahkan hubungi admin',
            ]);
        }
    // END

    // CHECK APAKAH USER SUDAH MENDAFTAR
        try{
            $jmlh_kelas_aktif_user = Auth::user()->whereHas(
                'DetailKelas' , function($query){
                    $query->whereHas('Kelas',function($query_2){
                        $query_2->whereDate('tanggal_selesai','>',date('Y-m-d'));
                    })->whereHas('Transaksi', function($query_3){
                        $query_3->where('status','memilih_metode_pembayaran')->orWhere('status','menunggu_pembayaran')->orWhere('status','menunggu_konfirmasi')->orWhere('status','lunas');
                    });
            })->count();

            if($jmlh_kelas_aktif_user > 0){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Anda Telah Mendaftar',
                    'message' => 'Saat ini anda telah mendaftar di salah satu course TCI Universitas Udayana, lebih lengkap cek pada halaman KELAS SAYA',
                ]);
            }

        }catch(ModelNotFoundException $err){
            return redirect()->back()->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Anda Telah Mendaftar',
                'message' => 'Saat ini anda telah mendaftar di salah satu course TCI Universitas Udayana, lebih lengkap cek pada halaman KELAS SAYA',
            ]);
        }
    // END
        
    // SECURITY
        $validator = Validator::make($request->all(),
        [
            'id_kelas' => 'required|exists:kelas,id',
        ]);

        if($validator->fails()){
            return redirect()->back()->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Kelas tidak ditemukan',
                'message' => 'Pastikan anda memilih kelas yang benar',
            ]);
        }
    // END
    
    // MAIN LOGIC
        try{
            $kelas = Kelas::whereHas('Pendaftaran',function($query){
                $query->whereDate('tanggal_mulai_pendaftaran','<=',date('Y-m-d'))
                        ->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))
                        ->where('status','aktif');
            })->where('status','buka')->where('id',$request->id_kelas)->whereDate('tanggal_mulai','<=',date('Y-m-d')
                )->whereDate('tanggal_selesai','>',date('Y-m-d'))
                ->firstOrFail();
            
        }catch(ModelNotFoundException $err){
            return redirect()->back()->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Kelas tidak ditemukan',
                'message' => 'Kelas yang dimaksud tidak ditemukan / tidak ada kecocokan',
            ]);
        }
    // END
    }
}
