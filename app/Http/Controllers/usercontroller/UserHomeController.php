<?php

namespace App\Http\Controllers\usercontroller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pendaftaran;

class UserHomeController extends Controller
{
    // INDEX
    public function index(){

        // GET ALL PENDAFTARAN
        $pendaftarans = Pendaftaran::where('status','aktif')
                                    ->where('tanggal_mulai_pendaftaran','<=',date('Y-m-d H:i:s'))
                                    ->where('tanggal_selesai_pendaftaran','>',date("Y-m-d H:i:s"))
                                    ->get();
        
        // JAM
        $jam = date('H');

        return view('user-dashboard.user-dashboard-beranda',compact(['pendaftarans','jam']));
    }
}
