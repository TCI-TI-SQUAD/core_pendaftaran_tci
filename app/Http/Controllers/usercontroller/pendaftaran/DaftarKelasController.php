<?php

namespace App\Http\Controllers\usercontroller\pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;
use Auth;
use Carbon\Carbon;

use App\PengaturanSistem;
use App\Kelas;
use App\User;
use App\DetailKelas;
use App\Transaksi;
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
        $jmlh_kelas_aktif_user = User::withCount([
            'DetailKelas' => function($query){
                $query->whereHas('Kelas',function($query_2){
                    $query_2->whereDate('tanggal_selesai','>',date('Y-m-d'));
                })->whereHas('Transaksi', function($query_3){
                    $query_3->where('status','memilih_metode_pembayaran')->orWhere('status','menunggu_pembayaran')->orWhere('status','menunggu_konfirmasi')->orWhere('status','lunas');
                });
        }])->find(Auth::user()->id);

        if($jmlh_kelas_aktif_user->detail_kelas_count > 0){
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
        /**
         * DISINI DISARING LAGI, PENDAFTARAN HARUS AKTIF, TANGGAL HARUS AKTIF,KELAS KERJASAMA JUGA HARUS ADA
         */
        try{
            $kelas = Kelas::with(['Pendaftaran'=>function($query){
                $query->whereDate('tanggal_mulai_pendaftaran','<=',date('Y-m-d'))
                        ->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))
                        ->where('status','aktif');
                }])->whereHas('KelasKerjasama',function($query_2){
                    $query_2->where('id_instansi',Auth::user()->id_instansi)->where('status',Auth::user()->status);
                })
                ->where('status','buka')->where('id',$request->id_kelas)->whereDate('tanggal_mulai','<=',date('Y-m-d')
                    )->whereDate('tanggal_selesai','>',date('Y-m-d'))
                    ->firstOrFail();
            
            // SIMPAN PENDAFTAR KELAS BARU
                // GENERATE NOMOR KELAS
                $nomor_kelas = DetailKelas::count('id_kelas',$kelas->id)+1;

                // INPUT KELAS
                $detail_kelas = DetailKelas::create([
                    'id_kelas' => $kelas->id,
                    'id_user' => Auth::user()->id,
                    'nomor_pelajar_kelas' => $nomor_kelas,
                ]);

                // GENERATE NOMOR_TRANSAKSI
                $id_transaksi = DB::select("SHOW TABLE STATUS LIKE 'transaksis'")[0]->Auto_increment;
                $generate_nomor_transaksi = date("Ymd").'-'.$detail_kelas->id.'-'.sprintf("%05d",$id_transaksi);
                
                if($kelas->isBerbayar){
                    // TRANSAKSI
                    $transaksi = Transaksi::create([
                        'id_detail_kelas' => $detail_kelas->id,
                        'nama_kelas' => $kelas->nama_kelas,
                        'nama_pendaftaran' => $kelas->Pendaftaran->nama_pendaftaran,
                        'nomor_transaksi_struct' => $generate_nomor_transaksi,
                        'total_pembayaran' => $kelas->harga,
                        'nama_pemesan' => Auth::user()->name,
                        'nomor_pelajar_tci' => Auth::user()->nomor_pelajar_tci,
                        'tanggal_expired' => Carbon::now()->addDays->format('Y-m-d'),
                        'tanggal_mulai_kelas' => $kelas->tanggal_mulai,
                        'tanggal_selesai_kelas' => $kelas->tanggal_selesai,
                        'status' => 'memilih_metode_pembayaran',
                    ]);
                    
                }else{
                    dd("kelas tidak bayar");
                }
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
