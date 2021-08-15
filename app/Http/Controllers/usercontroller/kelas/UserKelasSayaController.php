<?php

namespace App\Http\Controllers\usercontroller\Kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
                        $kelas_filter = function($query_kelas){
                            $query_kelas->withTrashed()->with(['Pengajar' => function($query_pengajar){
                            $query_pengajar->withTrashed();
                            }]);
                        };

                        $detail_kelas = DetailKelas::with([
                            'Kelas' => $kelas_filter
                            ,'Transaksi' => function($query_transaksi){
                                $query_transaksi->withTrashed();
                            }])->whereHas('User')->where('id_user',Auth::user()->id)->get();
                        
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;

                    case 'menunggu':
                        $detail_kelas = DetailKelas::with([
                            'Kelas' => function($query){
                                $query->with(['Pengajar' => function($query_pengajar){
                                    $query_pengajar->withTrashed();
                                }])->withTrashed();
                            },
                            'transaksi' => function($query_2){
                                $query_2->where('status','menunggu_pembayaran')
                                        ->orWhere('status','memilih_metode_pembayaran')
                                            ->orWhere('status','menunggu_konfirmasi')->withTrashed();
                            }
                            ])->whereHas('Transaksi',function($query_3){
                                $query_3->where('status','menunggu_pembayaran')
                                            ->orWhere('status','memilih_metode_pembayaran')
                                                ->orWhere('status','menunggu_konfirmasi')->withTrashed();;
                            })->whereHas('User')
                            ->where('id_user',Auth::user()->id)->get();
                        
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;
                    
                    case 'selesai':
                        $detail_kelas = DetailKelas::with([
                            'Kelas' => function($query_kelas){
                                $query_kelas->withTrashed();
                            },
                            'transaksi' => function($query){
                                $query->where('status','lunas')->withTrashed();
                            }
                            ])->whereHas('Transaksi',function($query_2){
                                $query_2->where('status','lunas')->withTrashed();
                            })->whereHas('User')
                            ->where('id_user',Auth::user()->id)->get();
                            
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;
                    
                    case 'dibatalkan':
                        $detail_kelas = DetailKelas::with([
                            'Kelas' => function($query_kelas){
                                $query_kelas->withTrashed();
                            },
                            'transaksi' => function($query){
                                $query->where('status','dibatalkan_user')
                                        ->orWhere('status','ditolak_admin')
                                            ->orWhere('status','expired_system')->withTrashed();
                            },
                            ])->whereHas('Transaksi',function($query_2){
                                $query_2->where('status','dibatalkan_user')
                                            ->orWhere('status','ditolak_admin')
                                                ->orWhere('status','expired_system')->withTrashed();
                            })->whereHas('User')
                            ->where('id_user',Auth::user()->id)->get();
                            
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
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
