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
                        $detail_kelas = DetailKelas::with([
                            'Kelas' =>function($query){
                                $query->with('Pengajar');
                            },'transaksi'])->where('id_user',Auth::user()->id)->get();
                        
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;

                    case 'menunggu':
                        $detail_kelas = DetailKelas::with([
                            'Kelas' =>function($query){
                                $query->with('Pengajar');
                            },
                            'transaksi' => function($query_2){
                                $query_2->where('status','menunggu_pembayaran')
                                        ->orWhere('status','memilih_metode_pembayaran')
                                            ->orWhere('status','menunggu_konfirmasi');
                            }
                            ])->whereHas('Transaksi',function($query_3){
                                $query_3->where('status','menunggu_pembayaran')
                                            ->orWhere('status','memilih_metode_pembayaran')
                                                ->orWhere('status','menunggu_konfirmasi');;
                            })
                            ->where('id_user',Auth::user()->id)->get();
                        
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;
                    
                    case 'selesai':
                        $detail_kelas = DetailKelas::with([
                            'Kelas',
                            'transaksi' => function($query){
                                $query->where('status','lunas');
                            }
                            ])->whereHas('Transaksi',function($query_2){
                                $query_2->where('status','lunas');
                            })
                            ->where('id_user',Auth::user()->id)->get();
                            
                        return view('user-dashboard.user-kelas-saya.user-kelas-saya',compact(['detail_kelas','filter']));
                        break;
                    
                    case 'dibatalkan':
                        $detail_kelas = DetailKelas::with([
                            'Kelas',
                            'transaksi' => function($query){
                                $query->where('status','dibatalkan_user')
                                        ->orWhere('status','ditolak_admin')
                                            ->orWhere('status','expired_system');
                            }
                            ])->whereHas('Transaksi',function($query_2){
                                $query_2->where('status','dibatalkan_user')
                                            ->orWhere('status','ditolak_admin')
                                                ->orWhere('status','expired_system');
                            })
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

    public function kelasBeranda(String $id_detail_kelas = null){
        // ENCRYPT
            try {
                $id_detail_kelas = Crypt::decryptString($id_detail_kelas);
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
            $validator = Validator::make(['id_detail_kelas' => $id_detail_kelas],[
                'id_detail_kelas' => 'required|exists:detail_kelas,id',
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
                                            ->where('id_user',Auth::user()->id)
                                                ->findOrFail($id_detail_kelas);

            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan mohon untuk memilih kelas yang ada',
                ]);
            }
            
            switch ($detail_kelas->Transaksi->status) {
                case 'lunas':
                    dd("lunas");
                    break;
                default:
                    return redirect()->route('user.pembayaran.kelas',[Crypt::encryptString($detail_kelas->id)])
                        ->with([
                            'status' => 'fail',
                            'icon' => 'info',
                            'title' => 'Selesaikan Administrasi Kelas !',
                            'message' => 'Untuk dapat masuk ke dalam kelas anda harus menyelesaikan administrasi kelas terlebih dahulu'
                        ]);
                    break;
            }
        // NED
    }
}
