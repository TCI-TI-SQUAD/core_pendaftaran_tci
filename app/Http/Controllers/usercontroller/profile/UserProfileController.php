<?php

namespace App\Http\Controllers\usercontroller\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use Storage;
use Carbon\Carbon;
use Hash;

use App\Notifications\UserSistemNotification;

class UserProfileController extends Controller
{
    public function index(){
        
        $user = Auth::user();

        return view('user-dashboard.user-profile.user-profile',compact('user'));
    }

    public function edit(){
        $user = Auth::user();

        return view('user-dashboard.user-profile.user-profile-edit',compact('user'));

    }

    public function store(Request $request){

        // SECURITY
            $validator = Validator::make($request->all(),[
                'name' => 'required|min:3|max:50',
                'username' => 'required|min:3|max:15',
                'hsk' => 'required|in:pemula,hsk 1,hsk 2,hsk 3,hsk 4,hsk 5,hsk 6,',
                'email' => 'required|email|unique:users,email,'.Auth::user()->id.'|min:5|max:50',
                'phone_number' => 'required|regex:/(\+62)[0-9]*$/|unique:users,phone_number,'.Auth::user()->id.'|min:7,max:15',
                'line' => 'required|min:3|unique:users,line,'.Auth::user()->id.'|max:50',
                'wa' => 'required|regex:/(\+62)[0-9]*$/|unique:users,wa,'.Auth::user()->id.'|min:7,max:15',
                'alamat' => 'required|string|min:5|max:100',
                'kartu_identitas' => 'required|mimes:png,jpg,jpeg,gif',
                'jenis_kartu_identitas' => 'required|in:ktp,nisn,ktm,passport',
                'password' => 'nullable|same:password_confirmation|min:8|max:100',
                'password_confirmation' => 'nullable|same:password|min:8|max:100',
                'kartu_identitas' => 'nullable|mimes:png,jpg,jpeg,gif|max:2000',
                'jenis_kartu_identitas' => 'required_with:kartu_identitas|in:ktp,nisn,ktm,passport',
                'image_user' => 'nullable|mimes:png,jpg,jpeg,gif|max:2000',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Terjadi Kesalahan',
                    'message' => 'Mohon untuk melakukan perubahan profile sesuai dengan aturan yang telah diberikan'
                ]);
            }
        // END

        // MAIN LOGIC
            // GET USER
                $user = Auth::user();
            

            // IMAGE PROCESS
                if($request->hasFile('image_user')){
                    if($user->user_profile_pict != 'default.jpg'){
                        Storage::delete('public\image_users\\'.$user->user_profile_pict);
                    }
                    $nama_image_user = basename($request->file('image_user')->store('public\image_users'));
                    $user->update(['user_profile_pict' => $nama_image_user]);
                }

                if($request->hasFile('kartu_identitas')){
                    if($user->kartu_identitas != 'default.jpg'){
                        Storage::delete('public\kartu_identitas\\'.$user->kartu_identitas);
                    }

                    $nama_kartu_identitas = basename($request->file('kartu_identitas')->store('public\kartu_identitas'));
                    $user->update([
                        'kartu_identitas' => $nama_kartu_identitas,
                        'jenis_kartu_identitas' => $request->jenis_kartu_identitas
                    ]);
                }
            // END

            // PASSWORD
                if($request->has('password')){
                    $user->update(['password' => Hash::make($request->password)]);
                }
            // END

            // DATA USER
                $user->update([
                    'name' => $request->name,
                    'username' => $request->username,
                    'hsk' => $request->hsk,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'line' => $request->line,
                    'wa' => $request->wa,
                    'alamat' => $request->alamat,
                ]);
            // END

            $data = [
                'title' => 'Profile Anda Diperbaharui',
                'message' => 'Profile anda telah berhasil diperbaharui',
                'datetime' => Carbon::now()->translatedFormat('l, F-d-Y H:i:s')." WITA",
                'color' => 'bg-info',
                'font-awesome-icon' => '<i class="far fa-id-badge"></i>',
            ];

            $user->notify(new UserSistemNotification($data));

            return redirect()->route('user.profile.index')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Memperbarui Profile',
                'message' => 'Profile anda telah berhasil diperbarui',
            ]);
                
    }
}
