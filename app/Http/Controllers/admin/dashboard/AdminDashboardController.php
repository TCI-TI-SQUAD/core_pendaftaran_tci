<?php

namespace App\Http\Controllers\admin\dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pendaftaran;

class AdminDashboardController extends Controller
{
    public function index(){
        return view('admin.admin.admin-dashboard');
    }
}
