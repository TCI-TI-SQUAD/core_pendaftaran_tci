<?php

namespace App\Http\Controllers\auth\authcotroller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use DB;
use Auth;

use App\PengaturanSistem;
use App\PengaturanSocialMedia;
use App\User;
use App\Universitas;
use App\Fakultas;
use App\Instansi;
use App\TipeSekolah;

class AuthController extends Controller
{
    public function index(){
        // AMBIL SEMUA DATA PENGATURAN SOSIAL MEDIA
        $social_medias = PengaturanSocialMedia::all();

        // GET HOURS
        $jam = date('H');

        return view('user-auth.user-login',compact(['social_medias','jam']));
    }

    public function register(){

        // AMBIL SEMUA UNIVERSITAS
        $universitas = Universitas::all();

        // AMBIL SEMUA JENJANG SEKOLAH
        $tipe_sekolahs = TipeSekolah::all();

        // AMBIL SEMUA INSTANSI
        $instansis = Instansi::all();

        return view('user-auth.user-register',compact(['universitas','tipe_sekolahs','instansis']));
    }

    public function loginPost(Request $request){
        // CHECK PENGATURAN SISTEMS
            try{
                $pengaturan_login = PengaturanSistem::where('nama_pengaturan','open_login')->firstOrFail()->status;
            }catch(ModelNotFoundException $err){
                $pengaturan_login = false;
            }

            if(!$pengaturan_login){
                return redirect()
                    ->back()
                    ->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Login Ditutup',
                        'message' => 'Login ke dalam sistem sedang di tutup oleh admin, mohon tunggu informasi lebih lanjut',
                    ])->withInput($request->all());
            }
        // END

        // SECURITY
            $request->validate([
                'email' => 'required|email|min:5|max:50',
                'password' => 'required|min:5|max:100',
                'remember_me' => 'nullable|boolean',
            ]);
        // END

        // MAIN LOGIC
            $remember = $request->remember_me == null ? false : true;

            if(Auth::attempt(['email' => $request->email, 'password' => $request->password],$remember)){
                return redirect()->route('user.dashboard');
            }else if(Auth::viaRemember()){
                return redirect()->route('user.dashboard');
            }else{
                return redirect()
                        ->back()
                        ->with([
                            'status' => 'fail',
                            'icon' => 'error',
                            'title' => 'Email atau Password Salah',
                            'message' => 'Periksa kembali email atau password anda',
                        ])->withInput($request->all());
            }
        // END
        
    }

    public function registerPost(Request $request){
        // CHECK PENGATURAN SISTEMS
            try{
                $pengaturan_registrations = PengaturanSistem::where('nama_pengaturan','open_registration')->firstOrFail()->status;
            }catch(ModelNotFoundException $err){
                $pengaturan_registrations = false;
            }

            if(!$pengaturan_registrations){
                return redirect()
                    ->back()
                    ->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Pendaftaran Ditutup',
                        'message' => 'Pendaftaran ke dalam sistem sedang di tutup oleh admin, mohon tunggu informasi lebih lanjut',
                    ])->withInput($request->all());
            }
        // END
        
        // SECURITY
            $request->validate([
                'name' => 'required|unique:users,name|min:5|max:50',
                'username' => 'required|unique:users,username|min:5|max:20',
                'email' => 'required|email|unique:users,email|min:5|max:50',
                'phone_number' => 'required|numeric|unique:users,phone_number|digits_between:7,15',
                'line' => 'required|min:3|unique:users,line|max:50',
                'wa' => 'required|numeric|unique:users,wa|digits_between:7,15',
                'alamat' => 'required|string|min:5|max:50',
                'password' => 'required|same:password_confirmation|min:8|max:100',
                'password_confirmation' => 'required|min:8|max:100',
                'status' => 'required|in:umum,siswa,mahasiswa,instansi',
                'kartu_identitas' => 'required|mimes:png,jpg,jpeg,gif',
                'jenis_kartu_identitas' => 'required|in:ktp,nisn,ktm,passport'
            ]);

            // VALIDATOR LANJUTAN
                if($request->status == 'siswa'){
                    $request->validate([
                        'tipe_sekolah' => 'required|numeric|exists:tipe_sekolahs,id',
                        'sekolah' => 'required|numeric|exists:sekolahs,id'
                    ]);
                    
                    $id_instansi = $request->sekolah;
                }else if ($request->status == 'mahasiswa'){
                    $request->validate([
                        'universitas' => 'required|numeric|exists:universitas,id',
                        'fakultas' => 'required|numeric|exists:fakultas,id',
                        'prodi' => 'required|numeric|exists:prodis,id'
                    ]);

                    $id_instansi = $request->prodi;
                }else if($request->status == 'instansi'){
                    $request->validate([
                        'instansi' => 'required|numeric|exists:instansis,id'
                    ]);

                    $id_instansi = $request->instansi;
                }else if($request->status == 'umum'){
                    $id_instansi = 0;
                }
            // END
        // END

        // SAVE KARTU IDENTITAS
            $nama_file = basename($request->file('kartu_identitas')->store('public\kartu_identitas'));
        // END

        // GENERATE NOMOR PELAJAR TCI
            $id_users_baru = DB::select("SHOW TABLE STATUS LIKE 'users'")[0]->Auto_increment;
            $generate_nomor_pelajar_tci = date("Ymd").sprintf("%05d",$id_users_baru);
        // END

        // MAIN LOGIC
            // CREATE USER BARU
                try{
                    User::create([
                        'id_instansi' => $id_instansi,
                        'status' => $request->status,
                        'name' => $request->name,
                        'nomor_pelajar_tci' => $generate_nomor_pelajar_tci,
                        'username' => $request->username,
                        'password' => Hash::make($request->password),
                        'email' => $request->email,
                        'phone_number' => $request->phone_number,
                        'kartu_identitas' => $nama_file,
                        'line' => $request->line,
                        'wa' => $request->wa,
                    ]);
                }catch(QueryException $err){
                    return redirect()
                        ->back()
                        ->with([
                            'status' => 'fail',
                            'icon' => 'error',
                            'title' => 'Gagal Membuat Akun',
                            'message' => 'Terjadi kesalahan saat membuat akun, apabila diperlukan mohon hubungi admin sistem',
                        ])->withInput($request->all());
                }
            // END

            // REDIRECT KE HALAMAN LOGIN
                return redirect()
                    ->route('user.landing-page')
                    ->with([
                        'status' => 'success',
                        'icon' => 'success',
                        'title' => 'Berhasil melakukan pendaftaran',
                        'message' => 'Selamat anda telah terdaftar menjadi peserta TCI Universitas Udayana, Silahkan login dan memilih kelas course',
                ]);
            // END
        // END

    }

    // AJAX GET universitas TYPE
    public function getFakultas(Request $request){
        // SECURITY
            $request->validate([
                'id' => 'required|exists:universitas,id|string'
            ]);
        // END
        
        // MAIN LOGIC
            try {
                $universitas = Universitas::with('Fakultas')->findOrFail($request->id);
                    return response()->json([
                        'status' => 200,
                        'message' => 'berhasil mengambil fakultas',
                        'universitas' => $universitas,
                    ]);
            }catch(ModelNotFoundException $err){

                    return response()->json([
                        'status' => 400,
                        'message' => 'Gagal Data Tidak Ditemukan',
                        'universitas' => (object) [],
                    ],400);
            }
        // END
            
    }

    // AJAX GET PRODI
    public function getProdi(Request $request){
        // SECURITY
            $request->validate([
                'id' => 'required|exists:fakultas,id|numeric'
            ]);
        // END
        
        // MAIN LOGIC
            try {
                $fakultas = Fakultas::with('Prodi')->findOrFail($request->id);

                return response()->json([
                    'status' => 200,
                    'message' => 'berhasil mengambil prodi',
                    'prodi' => $fakultas->Prodi,
                ]);

            }catch(ModelNotFoundException $err){

                return response()->json([
                    'status' => 400,
                    'message' => 'Gagal Data Tidak Ditemukan',
                    'prodi' => (object) [],
                ],400);
            }
        // END
            
    }

    // AJAX GET SEKOLAH
    public function getSekolah(Request $request){
        // SECURITY
            $request->validate([
                'id' => 'required|exists:tipe_sekolahs,id|numeric',
            ]);
        // END

        // MAIN LOGIC
            try{
                $tipe_sekolah = TipeSekolah::with('Sekolah')->findOrFail($request->id);

                return response()->json([
                    'status' => 200,
                    'message' => 'berhasil mengambil sekolah',
                    'sekolahs' => $tipe_sekolah->Sekolah,
                ]);

            }catch(ModelNotFoundException $err){
                return response()->json([
                    'status' => 400,
                    'message' => 'Gagal mengambil sekolah, tidak ada data yang sesuai',
                    'sekolahs' => (object) [],
                ]);
            }
            
    }

    // LOGOUT
    public function logout(){
        Auth::logout();

        return Redirect()->Route('user.landing-page');

    }
}
