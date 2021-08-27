<?php

namespace App\Http\Controllers\admin\pendaftaran_kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Auth;
use Validator;
use App\Pendaftaran;
use App\PengumumanPendaftaran;
class AdminPengumumanPendaftaranKelasController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => "Pendaftaran Tidak Ditemukan di Dalam Sistem",
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $pendaftaran = Pendaftaran::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => "Pendaftaran Tidak Ditemukan di Dalam Sistem",
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.pengumuman_pendaftaran_kelas\admin-pendaftaran-kelas-pengumuman-index',compact(['pendaftaran']));
        // END
    }

    public function createPengumumanPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => "Pendaftaran Tidak Ditemukan di Dalam Sistem",
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $pendaftaran = Pendaftaran::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => "Pendaftaran Tidak Ditemukan di Dalam Sistem",
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.pengumuman_pendaftaran_kelas\admin-pendaftaran-kelas-pengumuman-create',compact(['pendaftaran']));
        // END
    }

    public function postCreatePengumumanPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
                'pengumuman' => 'required|string',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Validasi tidak berhasil dilakukan',
                ]);
            }
        // END

        // MAIN LOGIC
            PengumumanPendaftaran::create([
                'id_pendaftaran' => $request->id,
                'id_admin' => Auth::guard("admin")->user()->id,
                'pengumuman' => $request->pengumuman,
                'tanggal' => date("Y-m-d"),
            ]);
        // END

        // RETURN
            return redirect()->route('admin.index.pengumuman.pendaftarankelas',[$request->id])->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Membuat Pengumuman',
                'message' => 'Pengumuman telah berhasil dibuat di dalam sistem',
            ]);
        // END
    }

    public function ajaxPengumumanPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id'
            ]);

            if($validator->fails()){
                return abort(403,"Unauthorized Access");
            }
        // END

        // MAIN LOGIC
            try{
                $pengumumans = json_encode(["data" => PengumumanPendaftaran::with("Admin")->where('id_pendaftaran',$request->id)->get()
                                    ->map(function($value,$index){
                                            $value['number'] = $index+-1;
                                            return $value;
                                        })]);
            }catch(ModelNotFoundException $err){
                return abort(403,"Unauthorized Access");
            }
        // END
            
        // RETURN
            return $pengumumans;
        // END
    }

    public function deletePengumumanPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pengumuman_pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pengumuman Pendaftaran Tidak Ditemukan',
                    'message' => 'Pengumuman pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                PengumumanPendaftaran::findOrFail($request->id)->delete();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pengumuman Pendaftaran Tidak Ditemukan',
                    'message' => 'Pengumuman pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Menghapus Pengumuman Pendaftaran',
                'message' => "Pengumuman berhasil dihapus dari sistem"
            ]);
        // END
    }
}
