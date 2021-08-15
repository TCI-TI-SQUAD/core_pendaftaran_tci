<?php

namespace App\Http\Controllers\admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Auth;

class AdminAuthController extends Controller
{
    public function LoginIndex(){
        return view('admin.admin-auth.admin-login');
    }

    public function postLogin(Request $request){

    // VALIDATOR
            $validator = Validator::make($request->all(),[
                'email' => 'required|email',
                'password' => 'required|min:3|max:100',
                'rememberme' => 'nullable|boolean',
                'g-recaptcha-response' => 'required|captcha',
            ]);

            if($validator->fails()){
                return redirect()->back()->withErrors($validator->errors())->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'titla' => 'Gagal Login !',
                    'message' => 'Mohon input credential yang benar !'
                ]);
            }
        // END

        // MAIN LOGIC
        
        $rememberme = $request->rememberme != null ? true : false ;

        if(Auth::guard('admin')->attempt(['email' => $request->email, 'password' => $request->password],$rememberme)){
            return redirect()->route('admin.dashboard');
        }else{
            return redirect()->back()->withErrors($validator->errors())->with([
                'status' => 'fail',
                'icon' => 'error',
                'titla' => 'Gagal Login !',
                'message' => 'Mohon input credential yang benar !'
            ]);
        }
    }

    public function postLogout(){
        Auth::guard('admin')->logout();

        return redirect()->route('admin.auth.login')->with([
            'status'=> 'success',
            'icon' => 'success',
            'title' => 'Berhasil Logout',
            'message' => 'Berhasil melakukan logout !',
        ]);
    }
}
