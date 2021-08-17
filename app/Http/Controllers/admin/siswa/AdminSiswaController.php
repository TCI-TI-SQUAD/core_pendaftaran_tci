<?php

namespace App\Http\Controllers\admin\siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Hash;
use Validator;
use Storage;


use App\User;
use App\Universitas;
use App\Instansi;
use App\TipeSekolah;

class AdminSiswaController extends Controller
{
    public function index(){
        return view('admin.admin.siswa.admin-siswa');
    }

    public function detailSiswa(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih siswa yang terdata di dalam sistem'
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
                    'message' => 'Mohon untuk memilih siswa yang terdata di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.siswa.admin-detail-siswa',compact(['user']));
        // END
    }

    public function editSiswa(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->route('admin.siswa')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih siswa yang ada di dalam sistem'
                ]);
            }
        // NED

        // MAIN LOGIC
            try{
                $user = User::findOrFail($request->id);

                // AMBIL SEMUA UNIVERSITAS
                $universitas = Universitas::all();

                // AMBIL SEMUA JENJANG SEKOLAH
                $tipe_sekolahs = TipeSekolah::all();

                // AMBIL SEMUA INSTANSI
                $instansis = Instansi::all();

            }catch(ModelNotFoundException $err){
                return redirect()->route('admin.siswa')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Siswa Tidak Ditemukan',
                    'message' => 'Mohon untuk memilih siswa yang ada di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.siswa.admin-edit-siswa',compact(['user','instansis','universitas','tipe_sekolahs']));
        // END
    }

    public function storeSiswa(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
                'name' => 'required|unique:users,name,'.$request->id.'|min:5|max:50',
                'username' => 'required|unique:users,username,'.$request->id.'|min:5|max:20',
                'nomor_pelajar_tci' => 'required|numeric',
                'email' => 'required|email|unique:users,email,'.$request->id.'|min:5|max:50',
                'phone_number' => 'required|regex:/(\+62)[0-9]*$/|unique:users,phone_number,'.$request->id.'|min:7,max:15',
                'line' => 'required|min:3|unique:users,line,'.$request->id.'|max:50',
                'wa' => 'required|regex:/(\+62)[0-9]*$/|unique:users,wa,'.$request->id.'|min:7,max:15',
                'alamat' => 'required|string|min:5|max:100',
                'hsk' => 'required|in:pemula,hsk 1,hsk 2,hsk 3,hsk 4,hsk 5,hsk 6,',
                'password' => 'nullable|min:8|max:100',
                'password_confirmation' => 'nullable|required_with:password|same:password|min:8|max:100',
                'hak_akses' => 'required|in:aktif,ban',
                'status' => 'nullable|in:umum,siswa,mahasiswa,instansi',
                'user_profile_pict' => 'nullable|mimes:png,jpg,jpeg,gif|max:2000',
                'kartu_identitas' => 'nullable|mimes:png,jpg,jpeg,gif|max:2000',
                'jenis_kartu_identitas' => 'required_with:kartu_identitas|in:ktp,nisn,ktm,passport',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi gagal 1',
                    'message' => 'Mohon untuk melakukan input sesuai dengan aturan'
                ])->withErrors($validator->errors());
            }

            // VALIDATOR LANJUTAN
                if($request->status != null){
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
                }
            // END
        // END

        // MAIN LOGIC
            try{
                $user = User::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'User Tidak Ditemukan',
                    'message' => 'User tidak ditemukan di dalam sistem'
                ]);
            }

            // IMAGE PROCESSOR
                if($request->hasFile('user_profile_pict')){
                    if($user->user_profile_pict != 'default.jpg'){
                        Storage::delete('public\image_users\\'.$user->user_profile_pict);
                    }
                    $nama_image_user = basename($request->file('user_profile_pict')->store('public\image_users'));
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

            // STATUS INSTASI
                if($request->status != null){
                    $user->update([
                        'id_instansi' => $id_instansi,
                        'status' => $request->status,
                    ]);
                }
            // END

            // DATA USER
                $user->update([
                    'name' => $request->name,
                    'nomor_pelajar_tci' => $request->nomor_pelajar_tci,
                    'username' => $request->username,
                    'hsk' => $request->hsk,
                    'hak_akses' => $request->hak_akses,
                    'email' => $request->email,
                    'phone_number' => $request->phone_number,
                    'line' => $request->line,
                    'wa' => $request->wa,
                    'alamat' => $request->alamat,
                ]);
            // END
            
        // END

        // RETURN
            return redirect()->route('admin.detail.siswa',[$request->id])->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Memperbarui Profile',
                'message' => 'Profile anda telah berhasil diperbarui',
            ]);
        // END

    }

    public function deleteSiswa(Request $request){
        // VALIDATOR
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:users,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'id siswa tidak ditemukan',
                    'message' => 'mohon untuk memilih siswa yang ada pada sistem !'
                ]);
            }
        //

        // MAIN LOGIC
            try{
                User::find($request->id)->delete();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'id siswa tidak ditemukan',
                    'message' => 'mohon untuk memilih siswa yang ada pada sistem !'
                ]);
            }
        // END

        // RETURN
            return redirect()->route('admin.siswa')->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Siswa Berhasil Dihapus',
                'message' => 'Siswa telah berhasil dihapus dari sistem',
            ]);
        // END
    }

    public function ajaxDataSiswa(){

        $users = User::get(['id','status','hsk','name','nomor_pelajar_tci','username','email','phone_number','line','wa','alamat','user_profile_pict','hak_akses','created_at','updated_at']);
        
        $users = $users->map(function ($item, $index) {
            $item['number'] =  $index + 1;
            return $item;
        })->toArray();

        $data = ["data" => $users];
        
        return \json_encode($data);
    }

}
