<?php

namespace App\Http\Controllers\usercontroller\pendaftaran;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Carbon\Carbon;
use Carbon\CarbonPeriod;


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

                $periods = CarbonPeriod::create($kelas->tanggal_mulai,$kelas->tanggal_selesai);

                if($kelas->JadwalKelas->count() <= 0){
                    return redirect()->route('user.dashboard')->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Kelas tidak ditemukan',
                        'message' => 'Kelas tidak ditemukan di dalam sistem',
                    ]);
                }

                $real_period = [];

                foreach($periods as $index => $period){
                    foreach($kelas->JadwalKelas as $jadwal){
                        if(strtolower($period->format('l')) == $jadwal->hari){
                            $real_period[$index]['period'] = $period;
                            $real_period[$index]['jadwal'] = $jadwal;
                        }
                    }
                }

                $real_period = array_values($real_period);
                
                return view('user-dashboard.user-jadwal-kelas',compact(['kelas','real_period']));

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
