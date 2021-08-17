<?php

namespace App\Http\Controllers\admin\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

use App\User;
use App\UserNotification;

class AdminSiswaNotifikasiController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
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
                $user = User::findOrFail($request->id);
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
            return view('admin.admin.siswa.admin-notifikasi-siswa',compact(['user']));
        // END
    }

    public function deleteNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Notifikasi Tidak Ditemukan',
                    'message' => 'Notifikasi tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                UserNotification::findOrFail((int) $request->id)->delete();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Notifikasi Tidak Ditemukan 2',
                    'message' => 'Notifikasi tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return redirect()->back()->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Menghapus Notifikasi',
                'message' => 'Notifikasi berhasil dihapus dari sistem',
            ]);
        // END
    }

    public function ajaxDataNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa tidak ditemukan !',
                    'message' => 'ID Siswa tidak ditemukan di dalam sistem, pastikan siswa yang dimaksud tidak dihapus sebelumnya dari sistem',
                ]);
            }
        // END

        // MAIN
            try{
                $notifications = User::findOrFail(1)->notifications->map(function($value,$key){
                                        $notification_data = json_decode($value->data);
                                        $new_item = [
                                            'number' => $key+1,
                                            'id' => $value->id,
                                            'title' => $notification_data->title,
                                            'message' => $notification_data->message,
                                            'datetime' => $notification_data->datetime,
                                            'color' => $notification_data->color,
                                            'icon' => $notification_data->icon,
                                        ];

                                        return $new_item;
                                    });

            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa tidak ditemukan !',
                    'message' => 'ID Siswa tidak ditemukan di dalam sistem, pastikan siswa yang dimaksud tidak dihapus sebelumnya dari sistem',
                ]);
            }
        // END

        // RETURN
            $data = ["data" => $notifications];

            return \json_encode($data);
        // END
    }
}
