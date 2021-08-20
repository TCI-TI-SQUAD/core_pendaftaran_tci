<?php

namespace App\Http\Controllers\admin\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Validator;

use App\User;
use App\UserNotification;
use Carbon\Carbon;
use App\Notifications\UserSistemNotification;

class AdminSiswaNotifikasiController extends Controller
{
    public $icons = array("fa fa-check",'fa fa-search','fa fa-star','fa fa-user','fa fa-times','fa fa-power-off','fa fa-cog','fa fa-trash','fa fa-home','fa fa-file','fa fa-clock','fa fa-download','fa fa-inbox','fa fa-exclamation-circle','fa fa-exclamation-triangle','fa fa-comment');

    
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

    public function createNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'error' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Siswa tidak ditemukan di dalam sistem !',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $user = User::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'error' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Siswa tidak ditemukan di dalam sistem !',
                ]);
            }
        // END
            
        // RETURS            
            return view('admin.admin.siswa.admin-create-notifikasi-siswa',['user' => $user, 'icons' => $this->icons]);
        // END
    }

    public function storeNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
                'title' => 'required|string|min:3|max:20',
                'icon' => 'required|string',
                'message' => 'required|string',
                'color' => 'required|string',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk memberikan input sesuai dengan arahan'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $user = User::findOrFail($request->id);
                
                $data = [
                    'title' => $request->title,
                    'message' => $request->message,
                    'datetime' => Carbon::now()->translatedFormat('l, F-d-Y H:i:s')." WITA",
                    'color' => $request->color,
                    'icon' => $request->icon,
                ];
    
                $user->notify(new UserSistemNotification($data));

            }catch(ModelNotFoundException $err){
                return redirect()->back()->withErrors($validator->errors())->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pengiriman Gagal !',
                    'message' => 'Pengiriman notifikasi gagal'
                ]);
            }
        // END

        // RETURN
            return redirect()->route('admin.detail.siswa',[$request->id])->with([
                    'status' => 'success',
                    'icon' => 'success',
                    'title' => 'Berhasil Mengirim Notifikasi',
                    'message' => 'berhasil Mengirim Notifikasi'
            ]);
        // END
    }

    public function updateNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make(['id_notifikasi' => $request->id_notifikasi],[
                'id_notifikasi' => 'required|numeric',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status'=> 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input dengan benar',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $notification = UserNotification::findOrFail((int) $request->id_notifikasi);
                $user = $notification->User()->firstOrFail();
                $notification->getFullDataAttribute();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status'=> 'fail',
                    'icon' => 'error',
                    'title' => 'Notifikasi Tidak Ditemukan !',
                    'message' => 'Notifikasi tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.siswa.admin-notifikasi-edit-siswa',['user' => $user,'notification' => $notification,'icons' => $this->icons]);
        // END
    }

    public function storeUpdateNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id_notifikasi' => 'required|numeric',
                'title' => 'required|string|min:3|max:20',
                'icon' => 'required|string',
                'message' => 'required|string',
                'color' => 'required|string',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status'=> 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input dengan benar',
                ]);
            }
        // END

        // MAIN LOGIC   
            try{
                $notification = UserNotification::findOrFail((int) $request->id_notifikasi);

                $data = [
                    'title' => $request->title,
                    'message' => $request->message,
                    'datetime' => Carbon::now()->translatedFormat('l, F-d-Y H:i:s')." WITA",
                    'color' => $request->color,
                    'icon' => $request->icon,
                ];

                $notification->update([
                    'data' => json_encode($data),
                ]);
                
                $user = $notification->User()->firstOrFail();

            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status'=> 'fail',
                    'icon' => 'error',
                    'title' => 'Notifikasi Tidak Ditemukan',
                    'message' => 'Notifikasi tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return redirect()->route("admin.notifikasi.siswa.index",[$user->id])->with([
                'status'=> 'success',
                'icon' => 'success',
                'title' => 'Notifikasi Berhasil Diperbarui',
                'message' => 'Notifikasi berhasil diperbaharui oleh sistem',
            ]);
        // END
    }

    public function ajaxDataNotifikasiSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return abort(403, 'Unauthorized action.');
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
                                            ''
                                        ];

                                        return $new_item;
                                    });

            }catch(ModelNotFoundException $err){
                return abort(403, 'Unauthorized action.');
            }
        // END

        // RETURN
            $data = ["data" => $notifications];

            return \json_encode($data);
        // END
    }
}
