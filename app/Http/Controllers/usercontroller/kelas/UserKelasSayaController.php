<?php

namespace App\Http\Controllers\usercontroller\Kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use Validator;
use Auth;
use Crypt;

use App\DetailKelas;

class UserKelasSayaController extends Controller
{
    public function index(String $filter = "semua"){
        // SECURITY
            $validator = Validator::make(['filter' => $filter],[
                'filter' =>' required|in:semua,menunggu,dibatalkan,selesai',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Filter tidak sesuai',
                    'message' => 'Mohon gunakan filter yang telah diberikan',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                switch ($filter) {
                    case 'semua':
                        // FILTER KELAS
                        $kelas_filter = function($query_kelas){
                            $query_kelas->whereHas("Pendaftaran")->with(['Pengajar' => function($query_pengajar){
                                $query_pengajar->withTrashed();
                            }]);
                        };

                        // FILTER TRANSAKSI
                        $transaksi_filter = function($query_transaksi){
                            $query_transaksi->withTrashed();
                        };

                        try{

                            $detail_kelas = DetailKelas::with([
                                'Kelas' => $kelas_filter,
                                'Transaksi' => $transaksi_filter
                            ])
                            ->whereHas("Kelas",$kelas_filter)
                            ->whereHas("Transaksi",$transaksi_filter)
                            ->where('id_user',Auth::user()->id)->get();

                            return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));

                        }catch(QueryException $err){
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Gagal Mendapatkan Kelas',
                                'message' => 'Kelas tidak ditemukan di dalam sistem',
                            ]);
                        }

                        break;

                    case 'menunggu':
                       // FILTER KELAS
                       $kelas_filter = function($query_kelas){
                            $query_kelas->whereHas("Pendaftaran")->with(['Pengajar' => function($query_pengajar){
                                $query_pengajar->withTrashed();
                            }]);
                        };

                        // FILTER TRANSAKSI
                        $transaksi_filter = function($query_transaksi){
                            $query_transaksi->where('status','menunggu_pembayaran')
                                            ->orWhere('status','memilih_metode_pembayaran')
                                            ->orWhere('status','menunggu_konfirmasi')
                                            ->withTrashed();;
                        };

                        try{
                            
                            $detail_kelas = DetailKelas::with([
                                'Kelas' => $kelas_filter,
                                'transaksi' => $transaksi_filter
                                ])
                                ->whereHas("Transaksi",$transaksi_filter)
                                ->whereHas("Kelas",$kelas_filter)
                                ->where('id_user',Auth::user()->id)->get();
                            
                            return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));

                        }catch(QueryException $err){
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Gagal Mendapatkan Kelas',
                                'message' => 'Kelas tidak ditemukan di dalam sistem',
                            ]);
                        }

                        break;
                    
                    case 'selesai':
                        // FILTER KELAS
                        $kelas_filter = function($query_kelas){
                            $query_kelas->whereHas("Pendaftaran")->with(['Pengajar' => function($query_pengajar){
                                $query_pengajar->withTrashed();
                            }]);
                        };

                        // FILTER TRANSAKSI
                        $transaksi_filter = function($query_transaksi){
                            $query_transaksi->where('status','lunas')
                                            ->withTrashed();;
                        };

                        try{
                            
                            $detail_kelas = DetailKelas::with([
                                'Kelas' => $kelas_filter,
                                'transaksi' => $transaksi_filter,
                                ])
                                ->whereHas("Kelas",$kelas_filter)
                                ->whereHas('Transaksi',$transaksi_filter)
                                ->where('id_user',Auth::user()->id)->get();
                                
                            return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));

                        }catch(QueryException $err){
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Gagal Mendapatkan Kelas',
                                'message' => 'Kelas tidak ditemukan di dalam sistem',
                            ]);
                        }

                        break;
                    
                    case 'dibatalkan':
                        // FILTER KELAS
                        $kelas_filter = function($query_kelas){
                            $query_kelas->whereHas("Pendaftaran")->with(['Pengajar' => function($query_pengajar){
                                $query_pengajar->withTrashed();
                            }]);
                        };

                        // FILTER TRANSAKSI
                        $transaksi_filter = function($query_transaksi){
                            $query_transaksi->where('status','dibatalkan_user')
                                            ->orWhere('status','ditolak_admin')
                                            ->orWhere('status','expired_system')->withTrashed();
                        };

                        try{
                            
                            $detail_kelas = DetailKelas::with([
                                'Kelas' => $kelas_filter,
                                'transaksi' => $transaksi_filter,
                                ])
                                ->whereHas("Kelas",$kelas_filter)
                                ->whereHas('Transaksi',$transaksi_filter)
                                ->where('id_user',Auth::user()->id)->get();
                                
                            return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));

                        }catch(QueryException $err){
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Gagal Mendapatkan Kelas',
                                'message' => 'Kelas tidak ditemukan di dalam sistem',
                            ]);
                        }

                        break;

                    default:
                        return redirect()->back()->with([
                            'status'  => 'fail',
                            'icon' => 'error',
                            'title' => 'Terjadi Kesalahan',
                            'message' => 'Terjadi kesalahan mohon hubungi admin'
                        ]);
                        break;
                }
                
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status'  => 'fail',
                    'icon' => 'error',
                    'title' => 'Terjadi Kesalahan',
                    'message' => 'Terjadi kesalahan mohon hubungi admin'
                ]);
            }
        // END
            
    }

    public function kelasBeranda(String $detail_kelas_id = null){
        // ENCRYPT
            try {
                $encrypt_detail_kelas_id = Crypt::decryptString($detail_kelas_id);
            } catch (DecryptException $err) {
                return redirect()->back()->with([
                    'status'  => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih kelas yang telah ditentukan'
                ]);
            }
        // END
        
        // SECURITY
            $validator = Validator::make(['encrypt_detail_kelas_id' => $encrypt_detail_kelas_id],[
                'encrypt_detail_kelas_id' => 'required|exists:detail_kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih kelas yang telah ditentukan'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $detail_kelas = DetailKelas::with(['Kelas','Transaksi'])
                                        ->whereHas('Kelas')->whereHas('Transaksi')
                                            ->where('id_user',Auth::user()->id)->whereHas('User')
                                                ->findOrFail($encrypt_detail_kelas_id);

            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan mohon untuk memilih kelas yang ada',
                ]);
            }
            
            // LIHAT STATUS TRANSAKSI KELAS
                if($detail_kelas->Kelas->isBerbayar){
                    switch ($detail_kelas->Transaksi->status) {
                        case 'dibatalkan_user':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;

                        case 'expired_system':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;
                        
                        case 'ditolak_admin':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;

                        case 'memilih_metode_pembayaran' :
                            return redirect()->route('user.pembayaran.kelas',[$detail_kelas_id]);
                            break;
                        
                        case 'menunggu_pembayaran' :
                            return redirect()->route('user.upload.kelas',[$detail_kelas_id]);
                            break;

                        case 'menunggu_konfirmasi' :
                            return redirect()->route('user.verifikasi.kelas',[$detail_kelas_id]);
                            break;
                        
                        case 'lunas' :
                            return "berhasil";
                            break;

                        default:
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Kelas Tidak Ditemukan',
                                'message' => 'Kelas tidak ditemukan mohon untuk memilih kelas yang ada',
                            ]);
                            break;
                    }
                }else{
                    switch ($detail_kelas->Transaksi->status) {
                        case 'dibatalkan_user':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;

                        case 'expired_system':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;
                        
                        case 'ditolak_admin':
                            return redirect()->route('user.fail.kelas',[$detail_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'info',
                                'title' => 'Transaksi Gagal',
                                'message' => 'Transaksi ini telah gagal'
                            ]);
                            break;

                        case 'menunggu_konfirmasi' :
                            return redirect()->route('user.verifikasi.kelas',[$detail_kelas_id]);
                            break;
                        
                        case 'lunas' :
                            return "berhasil";
                            break;

                        default:
                            return redirect()->back()->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Kelas Tidak Ditemukan',
                                'message' => 'Kelas tidak ditemukan mohon untuk memilih kelas yang ada',
                            ]);
                            break;
                    }
                }
            
        // END
    }
    
}
