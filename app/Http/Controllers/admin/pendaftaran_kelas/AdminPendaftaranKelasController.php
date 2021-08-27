<?php

namespace App\Http\Controllers\admin\pendaftaran_kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use App\Pendaftaran;
use Carbon\Carbon;
use Validator;

class AdminPendaftaranKelasController extends Controller
{
    public function index(){
        return view('admin.admin.pendaftaran_kelas.admin-pendaftaran-kelas-index');
    }

    public function createPendaftaranKelas(){
        return view('admin.admin.pendaftaran_kelas.admin-pendaftaran-kelas-create');
    }

    public function storeCreatePendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'nama_pendaftaran' => 'required|string|min:3|max:50|unique:pendaftarans,nama_pendaftaran',
                'tanggal_mulai_pendaftaran' => 'required|before:tanggal_selesai_pendaftaran',
                'tanggal_selesai_pendaftaran' => 'required|after:tanggal_mulai_pendaftaran',
                'keterangan' => 'required|string|min:3|max:100',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input sesuai dengan arahan sistem !'
                ])->withErrors($validator->errors())->withInput($request->all());
            }
        // END

        // MAIN LOGIC
            Pendaftaran::create([
                'nama_pendaftaran' => $request->nama_pendaftaran,
                'tanggal_mulai_pendaftaran' => $request->tanggal_mulai_pendaftaran,
                'tanggal_selesai_pendaftaran' => $request->tanggal_selesai_pendaftaran,
                'status' => $request->status,
            ]);
        // END

        // RETURN
            return redirect()->route('admin.pendaftarankelas')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Membuat Pendaftaran',
                'message' => 'Pendaftaran telah berhasil dibuat di dalam sistem',
            ]);
        // END
    }

    public function editPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem'
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
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.admin-pendaftaran-kelas-edit',compact(['pendaftaran']));
        // END
    }

    public function storeEditPendaftaranKelas(Request $request){

        // SECURITY
            $validator = Validator::make($request->all(),[
                'nama_pendaftaran' => 'required|string|min:3|max:50|unique:pendaftarans,nama_pendaftaran,'.$request->id,
                'tanggal_mulai_pendaftaran' => 'required|before:tanggal_selesai_pendaftaran',
                'tanggal_selesai_pendaftaran' => 'required|after:tanggal_mulai_pendaftaran',
                'keterangan' => 'required|string|min:3|max:100',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem'
                ]);
            }
        //END

        // MAIN LOGIC
            try{
                Pendaftaran::findOrFail($request->id)->update([
                    'nama_pendaftaran' => $request->nama_pendaftaran,
                    'tanggal_mulai_pendaftaran' => $request->tanggal_mulai_pendaftaran,
                    'tanggal_selesai_pendaftaran' => $request->tanggal_selesai_pendaftaran,
                    'status' => $request->status,
                ]);
            }catch(ModelNotFoundException $err){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return redirect()->route('admin.pendaftarankelas')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Update Pendaftaran',
                'message' => 'Berhasil update pendaftaran ke dalam sistem',
            ]);
        // END

    }

    public function archivedPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem !',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                Pendaftaran::findOrFail($request->id)->update([
                    'archived_at' => date("Y-m-d H:i:s"),
                ]);
            }catch(ModelNotFoundException $err){
                return redirect()->route('admin.pendaftarankelas')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem !',
                ]);
            }
        // END

        // RETURN
            return redirect()->route("admin.pendaftarankelas")->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Arsip Pendaftaran Berhasil',
                'message' => 'Arsip pendaftaran berhasil dilakukan',
            ]);
        // END
    }

    public function detailPendaftaranKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                "id" => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan !',
                    'message' => "Mohon untuk memilih pendaftaran dengan benar"
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
                    'title' => 'Pendaftaran Tidak Ditemukan !',
                    'message' => "Mohon untuk memilih pendaftaran dengan benar"
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.admin-pendaftaran-kelas-detail',compact(['pendaftaran']));
        // END
    }

    public function deletePendaftaranKelas(Request $request){
        // SECURYTI
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return abort(403,"Unauthorized Action");
            }
        // END

        // MAIN LOGIC
            try{
                Pendaftaran::findOrFail($request->id)->delete();
            }catch(ModelNotFoundException $err){
                return abort(403,"Unauthorized Action");
            }
        // END

        // RETURN
            return redirect()->route("admin.pendaftarankelas")->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Menghapus Pendaftaran',
                'message' => "Pendaftaran telah berhasil dihapus dari sistem",
            ]);
        // END
    }

    public function ajaxPendaftaranData(){
        $pendaftarans = json_encode(["data" => Pendaftaran::withCount('Kelas')->where("archived_at",null)->get()
                                        ->map(function($value,$index){
                                            $value['number'] = $index += 1;
                                            $value['tanggal_mulai_pendaftaran'] = Carbon::create($value['tanggal_mulai_pendaftaran'])->translatedFormat("l, Y-m-d H:i:s");
                                            $value['tanggal_selesai_pendaftaran'] = Carbon::create($value['tanggal_selesai_pendaftaran'])->translatedFormat("l, Y-m-d H:i:s");
                                            return $value;
                                        })]);

        return $pendaftarans;
    }
}
