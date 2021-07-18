<?php

namespace App\Http\Controllers\landingpage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Pendaftaran;

class LandingPageController extends Controller
{
    public function index(){
        
        // GET ALL PENDAFTARAN AKTIF DAN SUDAH MULAI
        $pendaftarans = Pendaftaran::where('status','aktif')
                                    ->where('tanggal_mulai_pendaftaran','<=',date('Y-m-d H:i:s'))
                                    ->where('tanggal_selesai_pendaftaran','>',date("Y-m-d H:i:s"))
                                    ->get();
        
        return view('user-landing-page.landing-page',compact(['pendaftarans']));
    }
}
