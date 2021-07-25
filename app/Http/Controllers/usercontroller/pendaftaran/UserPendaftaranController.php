<?php

namespace App\Http\Controllers\usercontroller\pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Auth;
use Crypt;
use Illuminate\Contracts\Encryption\DecryptException;
use DB;

use App\Pendaftaran;

class UserPendaftaranController extends Controller
{
    public function index($id = null){
        if(isset($id)){
            try {
                $id = Crypt::decryptString($id);
            } catch (DecryptException $err) {
                return Redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih opsi yang ada',
                ]);
            }
        }

        $validator = Validator::make(['id' => $id],[
            'id' => 'nullable|exists:pendaftarans,id'
        ]);

        if($validator->fails()){
            return Redirect()->back()->with([
                'status' => 'fail',
                'icon' => 'error',
                'title' => 'Pendaftaran Tidak Ditemukan',
                'message' => 'Mohon untuk memilih opsi yang ada',
            ]);
        }

        // MAIN LOGIC
            if(
                Pendaftaran::where('status','aktif')->whereDate('tanggal_mulai_pendaftaran','<=',date('Y-m-d'))
                            ->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))->count() > 0
            ){
                try{
                    // AMBIL SEMUA PENDAFTARAN
                    $semua_pendaftaran = Pendaftaran::with(['Kelas' => function($query){
                                                            $query->withCount(['DetailKelas' => function($query_2){
                                                                $query_2->whereHas('Transaksi',function($query_3){
                                                                    $query_3->where('status','!=','dibatalkan_user')->where('status','!=','expired_system')->where('status','!=','ditolak_admin');
                                                                });
                                                            }])->where('tanggal_mulai','<',date('Y-m-d'))->where('tanggal_selesai','>',date('Y-m-d'))
                                                                ->whereHas('KelasKerjasama',function($query_4){
                                                                    $query_4->where('status',Auth::user()->status)->where('id_instansi',Auth::user()->id_instansi);
                                                                });
                                                        }])->with(['PengumumanPendaftaran'])
                                                        ->where('status','aktif')
                                                        ->whereDate('tanggal_mulai_pendaftaran','<=',date('Y-m-d'))
                                                        ->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))
                                                        ->get();

                    if($id != null){
                        $pendaftaran = $semua_pendaftaran->where('id',$id)->first();
                    }
                    else{
                        $pendaftaran = $semua_pendaftaran->first();
                    }

                    foreach($pendaftaran->Kelas as $index => $kelas){
                        
                    }
                    
                    $pendaftaran->Kelas->filter(function($value,$key) use ($pendaftaran){
                        if(
                            $value->kuota <= $value->DetailKelas->count() ||
                            $value->status == 'tutup'
                        ){
                            $pendaftaran->Kelas[$key]->isLocked = true;
                            $pendaftaran->Kelas[$key]->Pengajar;
                            return true;
                        }else{
                            $pendaftaran->Kelas[$key]->isLocked = false;
                            $pendaftaran->Kelas[$key]->Pengajar;
                            return true;
                        }
                    })->sortBy('isLocked')->values();
                    
                    return view('user-dashboard.user-pendaftaran',compact(['pendaftaran','semua_pendaftaran']));

                }catch(ModelNotFoundException $err){
                    return Redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Pendaftaran Tidak Ditemukan',
                        'message' => 'Mohon untuk memilih opsi yang ada',
                    ]);
                }
            }else{
                return Redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Belum Ada Pendaftaran Courses',
                    'message' => 'Mohon tunggu informasi lebih lanjut atau hubungi admin sistem',
                ]);
            }
        // END
    }
}
