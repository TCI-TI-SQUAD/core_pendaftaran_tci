<?php

namespace App\Http\Controllers\admin\pendaftaran_kelas\kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use \Illuminate\Database\QueryException;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use App\Pendaftaran;
use App\Pengajar;
use App\Kelas;
use App\JadwalKelas;
use App\Instansi;
use App\Prodi;
use App\Sekolah;
use App\KelasKerjasama;
use App\Umum;

class AdminKelasController extends Controller
{
    public function index(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id'
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $pendaftaran = Pendaftaran::findOrFail($request->id);
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Tidak Ditemukan',
                    'message' => 'Pendaftaran tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-index',compact(['pendaftaran']));
        // END
    }

    public function detailKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                // DETAIL KELAS FILTER
                $detail_kelas_filter = function($query_detail_kelas){
                    $query_detail_kelas->whereHas('Transaksi',function($query_transaksi){
                        $query_transaksi->where('status','!=','dibatalkan_user')
                                        ->where('status','!=','expired_system')
                                        ->where('status','!=','ditolak_admin');
                    })->whereHas('User');
                };
                
                $kelas = Kelas::whereHas("Pendaftaran")
                                ->withCount(['DetailKelas' => $detail_kelas_filter])
                                ->with(["KelasKerjasama"])
                                ->findOrFail($request->id);
                
                $umum = $kelas->KelasKerjasama->where('status','umum')->values();
                $siswa = $kelas->KelasKerjasama->where('status','siswa')->values();
                $mahasiswa = $kelas->KelasKerjasama->where('status','mahasiswa')->values();
                $instansi = $kelas->KelasKerjasama->where('status','instansi')->values();
                
                $pendaftaran = $kelas->Pendaftaran()->firstOrFail();
                
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }catch(QueryException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }catch(\Throwable $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-detail',compact(['kelas','pendaftaran','umum','instansi','siswa','mahasiswa']));
        // END
    }

    public function createKelas(Request $request){
        // SECURITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Mohon untuk melakukan input sesuai arahan !',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                // PENDAFTARAN
                    $pendaftaran = Pendaftaran::findOrFail($request->id);
                
                // INSTANSI
                    $instansis = Instansi::all();

                // SEKOLAH
                    $sekolahs = Sekolah::all();

                // PRODI
                    $prodis = Prodi::orderBy("id_fakultas")->get();

                // PENGAJAR
                    $pengajars = Pengajar::all();
            }catch(ModelNotFoundException | QueryException | \Throwable $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Pendaftaran Atau Pengajar Tidak Ditemukan',
                    'message' => 'Mohon untuk melakukan input sesuai arahan !',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-create',compact(['pendaftaran','pengajars','sekolahs','prodis','instansis']));
        // END
    }

    public function postCreateKelas(Request $request){
        // SECURITY
            $size_array = 0;
            if(isset($request->jadwal['day'])){
                $size_array = count($request->jadwal['day']);
            }

            if(isset($request->harga)){
                $harga = \str_replace(".", "", $request->harga);
                $request->merge(['harga' => $harga]);
            }

            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
                'nama_kelas' => 'required|string|min:3|max:50|unique:kelas,nama_kelas',
                'hsk' => 'required|in:pemula,hsk 1,hsk 2,hsk 3,hsk 4,hsk 5,hsk 6',
                'tanggal_mulai' => 'required|date|before:tanggal_selesai',
                'tanggal_selesai' => 'required|date|after:tanggal_mulai',
                'isberbayar' => 'nullable|boolean',
                'harga' => 'nullable|required_with:isberbayar|numeric',
                'kuota' => 'required|numeric',
                'logo_kelas' => 'required|mimes:png,jpg,jpeg,gif|max:2000',
                'status' => 'required|in:buka,tutup',
                'id_pengajar' => 'required|exists:pengajars,id',
                'jadwal' => 'required|array',
                'jadwal.day' => 'required|array|size:'.$size_array,
                'jadwal.waktu_mulai' => 'required|array|size:'.$size_array,
                'jadwal.waktu_selesai' => 'required|array|size:'.$size_array,
                'jadwal.day.*' => 'required|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
                'jadwal.waktu_mulai.*'=> 'required|date_format:H:i',
                'jadwal.waktu_selesai.*'=> 'required|date_format:H:i',
                'umum' => 'nullable|array',
                'umum.*' => 'nullable|numeric',
                'prodi' => 'nullable|array',
                'prodi.*' => 'nullable|exists:prodis,id',
                'sekolah' => 'nullable|array',
                'sekolah.*' => 'nullable|exists:sekolahs,id',
                'instansi' => 'nullable|array',
                'instansi.*' => 'nullable|exists:instansis,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Validasi Gagal !',
                    'message' => 'Validasi gagal dilakukan, mohon untuk melakukan input dengan benar' ,
                ])->withErrors($validator->errors())->withInput($request->all());
            }

            foreach($request->jadwal['waktu_mulai'] as $index => $waktu_mulai){
                $carbon_waktu_mulai = Carbon::parse($waktu_mulai);
                $carbon_waktu_selesai = Carbon::parse($request->jadwal['waktu_selesai'][$index]);

                if($carbon_waktu_mulai->diffInSeconds($carbon_waktu_selesai,false) <= 0){
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Validasi Jadwal Kelas Gagal !',
                        'message' => 'Waktu mulai harus dimulai sebelum waktu selesai !' ,
                    ])->withErrors($validator->errors())->withInput($request->all());
                }
            }
        // END

        // MAIN LOGIC
            // IMAGE PROCESSOR
                $nama_file_logo_kelas = "default.jpg";
                if($request->hasFile('logo_kelas')){
                    $nama_file_logo_kelas = basename($request->file('logo_kelas')->store('public\image_kelas'));
                }
            // END

            // CREATE KELAS
                try{
                    $kelas = Kelas::create([
                                'id_pendaftaran' => $request->id,
                                'id_pengajar' => $request->id_pengajar,
                                'hsk' => $request->hsk,
                                'nama_kelas' => $request->nama_kelas,
                                'tanggal_mulai' => $request->tanggal_mulai,
                                'tanggal_selesai' => $request->tanggal_selesai,
                                'isBerbayar' => false,
                                'harga' => 0,
                                'kuota' => $request->kuota,
                                'status' => $request->status,
                                'logo_kelas' => $nama_file_logo_kelas,
                            ]);
                    
                    if(isset($request->isberbayar)){
                        $kelas->update([
                            'isBerbayar' => true,
                            'harga' => $request->harga
                        ]);
                    }
                    
                }catch (QueryException $exception) {
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Pembuatan Model Kelas Gagal !',
                        'message' => 'Pembuatan kelas gagal ! mohon hubungi developer sistem' ,
                    ])->withErrors($validator->errors())->withInput($request->all());
                }
            // END

            // CREATE JADWAL KELAS
                try{
                    $arrayJadwalKelas = [];

                    foreach($request->jadwal['day'] as $index => $day){
                        $arrayJadwalKelas[] = JadwalKelas::create([
                            'id_kelas' => $kelas->id,
                            'hari' => $day,
                            'waktu_mulai' => $request->jadwal['waktu_mulai'][$index],
                            'waktu_selesai' => $request->jadwal['waktu_selesai'][$index]
                        ]);
                    }

                    $collection_jadwal_kelas = collect($arrayJadwalKelas);

                }catch (QueryException $exception) {
                    
                    $kelas->forceDelete();
                    
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Pembuatan Model Jadwal Kelas Gagal !',
                        'message' => 'Pembuatan model jadwal kelas gagal ! mohon hubungi developer sistem' ,
                    ])->withErrors($validator->errors())->withInput($request->all());
                }
            // END

            // CREATE KELAS KERJA SAMA
                try{
                    // UMUM
                    if(isset($request->umum)){
                        KelasKerjasama::create([
                            'id_kelas' => $kelas->id,
                            'id_instansi' => 1,
                            'status' => 'umum',
                        ]);
                    }
                    
                    // PRODI
                    if(isset($request->prodi)){
                        if(count($request->prodi) > 0){
                           foreach($request->prodi as $index => $index_prodi) {
                                KelasKerjasama::create([
                                    'id_kelas' => $kelas->id,
                                    'id_instansi' => $index_prodi,
                                    'status' => 'mahasiswa',
                                ]);    
                           }
                        }
                    }
                    
                    // SISWA
                    if(isset($request->sekolah)){
                        if(count($request->sekolah) > 0){
                           foreach($request->sekolah as $index => $index_sekolah) {
                                KelasKerjasama::create([
                                    'id_kelas' => $kelas->id,
                                    'id_instansi' => $index_sekolah,
                                    'status' => 'siswa',
                                ]);
                           }
                        }
                    }

                    // INSTANSI
                    if(isset($request->instansi)){
                        if(count($request->instansi) > 0){
                           foreach($request->instansi as $index => $index_instansi) {
                                KelasKerjasama::create([
                                    'id_kelas' => $kelas->id,
                                    'id_instansi' => $index_instansi,
                                    'status' => 'instansi',
                                ]);
                           }
                        }
                    }
                }catch(QueryException $err){

                    $kelas->forceDelete();
                    
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Pembuatan Model Kelas Kerjasama Gagal !',
                        'message' => 'Pembuatan model kelas kerjasama gagal ! mohon hubungi developer sistem' ,
                    ])->withErrors($validator->errors())->withInput($request->all());
                }

        // END

        // RETURN
            return redirect()->route('admin.kelas',[$request->id])->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Membuat Kelas !',
                'message' => "Berhasil membuat kelas ke dalam sistem !",
            ]);
        // END
    }

    public function editKelas(Request $request){
        // SECURITY
            $validator = Validator::make(["id" => $request->id],[
                'id' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan !',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                 // DETAIL KELAS FILTER
                $detail_kelas_filter = function($query_detail_kelas){
                    $query_detail_kelas->whereHas('Transaksi',function($query_transaksi){
                        $query_transaksi->where('status','!=','dibatalkan_user')
                                        ->where('status','!=','expired_system')
                                        ->where('status','!=','ditolak_admin');
                    })->whereHas('User');
                };
                
                $kelas = Kelas::whereHas("Pendaftaran")
                                ->withCount(['DetailKelas' => $detail_kelas_filter])
                                ->with(["KelasKerjasama","JadwalKelas"])
                                ->findOrFail($request->id);

                $checked_umum = $kelas->KelasKerjasama->where('status','umum')->pluck("id_instansi")->toArray();
                $checked_sekolah = $kelas->KelasKerjasama->where('status','siswa')->pluck("id_instansi")->toArray();
                $checked_prodi = $kelas->KelasKerjasama->where('status','mahasiswa')->pluck("id_instansi")->toArray();
                $checked_instansi = $kelas->KelasKerjasama->where('status','instansi')->pluck("id_instansi")->toArray();

                // UMUM
                $umums = Umum::all();

                $umums->map(function($value,$index) use ($checked_umum){
                    if(in_array($value->id,$checked_umum)){
                        $value['checked'] = true;
                        return $value;
                    }else{
                        $value['checked'] = false;
                        return $value;
                    }
                });
                
                // INSTANSI
                $instansis = Instansi::all();

                $instansis->map(function($value,$index) use ($checked_instansi){
                    if(in_array($value->id,$checked_instansi)){
                        $value['checked'] = true;
                        return $value;
                    }else{
                        $value['checked'] = false;
                        return $value;
                    }
                });
                
                // SEKOLAH
                $sekolahs = Sekolah::all();

                $sekolahs->map(function($value,$index) use ($checked_sekolah){
                    if(in_array($value->id,$checked_sekolah)){
                        $value['checked'] = true;
                        return $value;
                    }else{
                        $value['checked'] = false;
                        return $value;
                    }
                });
                
                // PRODI
                $prodis = Prodi::orderBy("id_fakultas")->get();
                
                $prodis->map(function($value,$index) use ($checked_prodi){
                    if(in_array($value->id,$checked_prodi)){
                        $value['checked'] = true;
                        return $value;
                    }else{
                        $value['checked'] = false;
                        return $value;
                    }
                });
                

                // PENGAJAR
                $pengajars = Pengajar::all();
                
                // GET PENDAFTARAN
                $pendaftaran = $kelas->Pendaftaran()->firstOrFail();

            }catch(ModelNotFoundException | QueryException | \Throwable $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan !',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas-edit',compact(['kelas','pendaftaran','pengajars','instansis','sekolahs','prodis','umums']));
        // END
    }

    public function storeEditKelas(Request $request){
        // SECURITY
            $validator = Validator::make(["id" => $request->id],[
                'id' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan !',
                    'message' => 'Kelas tidak ditemukan di dalam sistem',
                ]);
            }
        // END

        // MAIN LOGIC
            // IMAGE PROCESSOR
                $nama_file_logo_kelas = "default.jpg";
                if($request->hasFile('logo_kelas')){
                    $nama_file_logo_kelas = basename($request->file('logo_kelas')->store('public\image_kelas'));
                }
            // END
        // END
    }

    public function deleteKelas(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => "required|exists:kelas,id",
                'id_pendaftaran' => "required|exists:pendaftarans,id",
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => "Kelas tidak ditemukan di dalam sistem !",
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                Kelas::where("id_pendaftaran",$request->id_pendaftaran)->findOrFail($request->id)->delete();
            }catch(ModelNotFoundException $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => "Kelas tidak ditemukan di dalam sistem !",
                ]);
            }
        // END

        // RETURN
            return redirect()->route('admin.kelas',[$request->id_pendaftaran])->with([
                'status' => 'success',
                'icon' => 'success',
                'title' => 'Berhasil Menghapus Kelas',
                'message' => 'Berhasil menghapus kelas dari sistem',
            ]);
        // END
    }

    public function ajaxKelasData(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:pendaftarans,id',
            ]);

            if($validator->fails()){
                return abort(403,"Unathorized Access");
            }
        // END

        // MAIN LOGIC
            try{
                // DETAIL KELAS FILTER
                $detail_kelas_filter = function($query_detail_kelas){
                    $query_detail_kelas->whereHas('Transaksi',function($query_transaksi){
                        $query_transaksi->where('status','!=','dibatalkan_user')->where('status','!=','expired_system')->where('status','!=','ditolak_admin');
                    })->whereHas('User');
                };

                $kelas = json_encode(["data" => Kelas::with("Pengajar")
                                                ->whereHas("Pendaftaran")
                                                ->withCount(['DetailKelas' => $detail_kelas_filter])
                                                ->where('id_pendaftaran',$request->id)
                                                ->get()
                                                ->map(function($value,$index){
                                                        $value['number'] = $index+=1;
                                                        $value['harga'] = number_format($value['harga'],0,".",".");
                                                        $value['tanggal_mulai'] = Carbon::create($value->tanggal_mulai)->translatedFormat("l, Y-m-d");
                                                        $value['tanggal_selesai'] = Carbon::create($value->tanggal_selesai)->translatedFormat("l, Y-m-d");
                                                        return $value;
                                    })]);
            }catch(ModelNotFoundException $err){
                return abort(403, "Unathorized Access");
            }catch(QueryException $err){
                return abort(403, "Unathorized Access");
            }
        // END
            
        // RETURN
            return $kelas;
        // END
    }
}
