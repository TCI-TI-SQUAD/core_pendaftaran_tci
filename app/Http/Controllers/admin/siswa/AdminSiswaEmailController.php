<?php

namespace App\Http\Controllers\admin\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserEmail;

use App\User;
use App\MailUser;

class AdminSiswaEmailController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' > 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Validasi gagal dilakukan, mohon untuk melakukan input sesuai aturan sistem'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $user = User::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' > 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Siswa tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.siswa.admin-email-siswa',compact(['user']));
        // END
    }

    public function createEmailSiswa(Request $request){
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
                $user = User::find($request->id);
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
            return view('admin.admin.siswa.admin-create-email-siswa',compact(['user']));
        // END
    }

    public function storeEmailSiswa(Request $request){
        // VALIDATOR
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
                'title' => 'required|string|min:3|max:15'
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input dengan benar'
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
                    'title' => 'Siswa Tidak Ditemukan !',
                    'message' => 'Siswa tidak ditemukan di dalam sistem',
                ]);
            }

            Mail::to($user->email)->send(new UserEmail($request->only(['title','subject','message'])));

            MailUser::create([
                'user_id' => $user->id,
                'title' => $request->title,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);
        // END

        // RETURN
            return redirect()->route('admin.email.siswa.index',[$user->id])->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Mengirim E-Mail',
                'message' => "E-Mail telah dikirim ke ".$user->email,
            ]);
        // END
    }

    public function ajaxSiswaEmailData(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id'
            ]);

            if($validator->fails()){
                return abort(403, 'Unauthorized action.');
            }
        // END

        // MAIN LOGIC
            try{
                $emails = User::findOrFail(1)->MailUser()->get()
                                    ->map(function($value,$key){
                                        $value['number'] = $key+=1;

                                        return $value;
                                    });
            }catch(ModelNotFoundException $err){
                return abort(403, 'Unauthorized action.');
            }
        // END

        // RETURN
            $data = ["data" => $emails];

            return json_encode($data);
        // END
    }
}
