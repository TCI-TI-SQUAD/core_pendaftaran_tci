<?php

namespace App\Http\Controllers\usercontroller\pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;

use App\Kelas;

class JadwalKelasController extends Controller
{
    public function index($id_kelas){
        // SECURITY
            $validator = Validator::make(['id_kelas' => $id_kelas],[
                'id_kelas' => 'required|numeric|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->route('user.dashboard')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // NED

        // MAIN LOGIC
            try{

                $kelas = Kelas::with('JadwalKelas')->whereHas('Pendaftaran',function($query){
                                    $query->where('status','aktif')->whereDate('tanggal_mulai_pendaftaran','<=',date('Y-m-d'))
                                        ->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'));
                                })->where('status','buka')->findOrFail($id_kelas);

                $days = ['sunday','monday','tuesday','wednesday','thursday','friday','saturday'];
                
                return view('user-dashboard.user-jadwal-kelas',compact(['kelas','days']));

            }catch(ModelNotFoundException $err){

                return redirect()->route('user.dashboard')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);

            }
        // NED
    }
}
