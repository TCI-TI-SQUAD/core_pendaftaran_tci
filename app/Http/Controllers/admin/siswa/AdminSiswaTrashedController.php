<?php

namespace App\Http\Controllers\admin\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;

use App\User;

class AdminSiswaTrashedController extends Controller
{
    public function index(){
            return view('admin.admin.siswa.admin-trashed-siswa');
    }

    public function restoreTrashedSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Siswa tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                User::withTrashed()->findOrFail($request->id)->restore();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Siswa tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Siswa Berhasil Dipulihkan !',
                'message' => 'Siswa sekarang telah berhasil dipulihkan, mohon perhatikan kelas yang diikuti siswa sebelumnya !'
            ]);
        // END
    }

    public function ajaxTrashedSiswaData(){
        // GET TRASHED DATA
            try{
                
                $users = User::onlyTrashed()->get()->map(function($value,$key){
                                        $value['number'] = $key+=1;
                                        return $value;
                                    });

            }catch(ModelNotFoundException $err){
                return abort(403, 'Unauthorized action.');
            }
        // END

        // MAIN LOGIC
            $data = json_encode(["data" => $users]);
        // END

        // RETURN
            return $data;
        // END
    }
}
