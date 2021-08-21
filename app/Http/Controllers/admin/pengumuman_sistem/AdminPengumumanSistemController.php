<?php

namespace App\Http\Controllers\admin\pengumuman_sistem;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;

use Validator;
use Auth;

use App\PengumumanGlobal;

class AdminPengumumanSistemController extends Controller
{
    public function index(){
        return view('admin.admin.pengumuman-sistem.admin-pengumuman-sistem-index');
    }

    public function createPengumumanSistem(){
        return view('admin.admin.pengumuman-sistem.admin-pengumuman-sistem-create');
    }

    public function storeCreatePengumumanSistem(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'pengumuman' => 'required|string',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Validasi gagal dilakukan, mohon untuk menginputkan data sesuai dengan aturan`',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                PengumumanGlobal::create([
                    'id_admin' => Auth::user()->id,
                    'pengumuman' => $request->pengumuman,
                    'tanggal' => date("Y-m-d"),
                ]);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Gagal Membuat Pengumuman',
                    'message' => 'Gagal membuat pengumuman, apabila diperlukan mohon hubungi developer sistem`',
                ]);
            }
        // END

        // RETURN
            return redirect()->route('admin.pengumuman.sistem')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Membuat Pengumuman',
                'message' => 'Pengumuman telah berhasil dibuat, sekarang user dapat melihat pengumuman anda`',
            ]);
        // END
    }

    public function deletePengumumanSistem(Request $request){
        // VALIDATOR
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pengumuman_globals,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pengumuman Tidak Ditemukan',
                    'message' => 'Pengumuman tidak ditemukan di dalam sistem !'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                PengumumanGlobal::findOrFail($request->id)->delete();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pengumuman Tidak Ditemukan',
                    'message' => 'Pengumuman tidak ditemukan di dalam sistem !'
                ]);
            }
        // END

        // RETURN
            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Menghapus Pengumuman',
                'message' => "Berhasil menghapus pengumuman dari sistem"
            ]);
        // END
    }

    public function ajaxPengumumumanSistemData(){
        // MAIN LOGIC
            try{
                
                $admin_filter = function($admin_query){
                    $admin_query->select('id','nama_admin');
                };

                $pengumumans = PengumumanGlobal::with(["Admin" => $admin_filter])->whereHas("Admin")->get()->map(function($value , $key){
                                                        $value['number'] = $key += 1;
                                                        return $value;
                                                    });

                $pengumumans = json_encode(["data" => $pengumumans]);

            }catch(ModelNotFoundException $err){
                return abort(403,"Unathorized Action");
            }
        // END

        // RETURN
            return $pengumumans;
        // END
        
    }
}
