<?php

namespace App\Http\Controllers\admin\pendaftaran_kelas\kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Carbon\Carbon;

use App\Pendaftaran;
use App\Pengajar;
use App\Kelas;


class AdminKelasController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id'
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $pendaftaran = Pendaftaran::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-index',compact(['pendaftaran']));
        // END
    }

    public function createKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input sesuai arahan !',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                // PENDAFTARAN
                    $pendaftaran = Pendaftaran::findOrFail($request->id);

                // PENGAJAR
                    $pengajars = Pengajar::all();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Atau Pengajar Tidak Ditemukan',
                    'message' => 'Mohon untuk melakukan input sesuai arahan !',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-create',compact(['pendaftaran','pengajars']));
        // END
    }

    public function postCreateKelas(Request $request){
        dd($request->all());
    }

    public function ajaxKelasData(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return abort(403,"Unathorized Access");
            }
        // END

        // MAIN LOGIC
            try{
                $kelas = json_encode(["data" => Kelas::with("Pengajar")->where('id_pendaftaran',$request->id)->get()
                                                ->map(function($value,$index){
                                                        $value['number'] = $index+=1;
                                                        $value['tanggal_mulai'] = Carbon::create($value->tanggal_mulai)->translatedFormat("l, Y-m-d");
                                                        $value['tanggal_selesai'] = Carbon::create($value->tanggal_selesai)->translatedFormat("l, Y-m-d");
                                                        return $value;
                                                })]);
            }catch(ModelNotFoundException $err){
                return abort(403, "Unathorized Access");
            }
        // END
            
        // RETURN
            return $kelas;
        // END
    }
}
