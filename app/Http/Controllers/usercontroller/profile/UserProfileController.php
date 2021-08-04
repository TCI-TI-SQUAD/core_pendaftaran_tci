<?php

namespace App\Http\Controllers\usercontroller\profile;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

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
        dd($request->all());
    }
}
