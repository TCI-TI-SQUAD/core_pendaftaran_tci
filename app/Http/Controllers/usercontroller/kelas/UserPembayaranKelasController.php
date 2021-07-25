<?php

namespace App\Http\Controllers\usercontroller\kelas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Validator;
use Crypt;
use Auth;
use Storage;
use Session;

use App\Kelas;
use App\DetailKelas;

class UserPembayaranKelasController extends Controller
{
    public function stepPembayaran(String $id_detail_kelas){
        // SECURITY
            try {
                $id_detail_kelas = Crypt::decryptString($id_detail_kelas);
            } catch (DecryptException $err) {
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan 13',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }

            $validator = Validator::make(['id_detail_kelas' => $id_detail_kelas],[
                'id_detail_kelas' => 'required|exists:detail_kelas,id'
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan 1',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $detail_kelas = DetailKelas::with([
                    'Kelas',
                    'Transaksi',
                ])->whereHas('Kelas')->whereHas('Transaksi')->where('id_user',Auth::user()->id)->findOrFail($id_detail_kelas);
                
            }catch(ModelNotFoundException $err){
                return redirect()->route('user.pendaftaran')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan 2',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }

            switch ($detail_kelas->Transaksi->status) {
                case 'dibatalkan_user':
                    return view('user-dashboard.user-kelas-saya.user-fail-pembayaran',compact(['detail_kelas']));
                    break;

                case 'expired_system':
                    return view('user-dashboard.user-kelas-saya.user-fail-pembayaran',compact(['detail_kelas']));
                    break;
                
                case 'ditolak_admin':
                    return view('user-dashboard.user-kelas-saya.user-fail-pembayaran',compact(['detail_kelas']));
                    break;

                default:
                    return view('user-dashboard.user-kelas-saya.user-pembayaran',compact(['detail_kelas']));
                    break;
            }

        // END
    }

    public function stepUploadBukti(String $id_detail_kelas){
        // DECRYPT
            try {
                $id_detail_kelas = Crypt::decryptString($id_detail_kelas);
            } catch (DecryptException $e) {
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                ]);
            }
        // END

        // SECURITY
            $validator = Validator::make(['id_detail_kelas' => $id_detail_kelas],[
                'id_detail_kelas' => 'required|exists:detail_kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                ]);
            }
        // END

        // AMBIL KELAS
            try{
                $detail_kelas = DetailKelas::with('Kelas','Transaksi')
                                                ->whereHas('Kelas')->whereHas('Transaksi')
                                                    ->where('id_user',Auth::user()->id)->findOrFail($id_detail_kelas);
            }catch(ModelNotFoundException $err){
                return redirect()->route('user.pendaftaran')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }
        // END
        
        // MEMASTIKAN STATUS DARI TRANSAKSI <= UPLOAD BUkTI
            switch ($detail_kelas->Transaksi->status) {
                case 'memilih_metode_pembayaran':
                    $detail_kelas->Transaksi->status = 'menunggu_pembayaran';
                    $detail_kelas->Transaksi->save();
                    break;
                
                default:
                    break;
            }
        // END

        return view('user-dashboard.user-kelas-saya.user-upload',compact(['detail_kelas']));
    }

    public function postBuktiPembayaran(Request $request){
        // DECRYPT
            try {
                $request->merge(['id_kelas' => Crypt::decryptString($request->id_kelas)]);
            } catch (DecryptException $e) {
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                ]);
            }
        // END

        // SECURITY
            $validator = Validator::make($request->all(),[
                'id_kelas' => 'required|exists:kelas,id',
                'file_bukti_pembayaran' => 'required|mimes:jpg,png,jtiff,bmp,jpeg,gif|max:2000'
            ]);
            
            if($validator->fails()){
                if($validator->errors()->has('file_bukti_pembayaran')){
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Bukti Pembayaran Error',
                        'message' => 'Pastikan file yang dikirim merupakan gambar dengan format jpg, png, jtiff, bmp atau jpeg dan max ukuran 2 MB'
                    ]);
                }else{
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Kelas Tidak Ditemukan',
                        'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                    ]);
                }
            }
            
        // END

        // MAIN LOGIC
            try{
                $kelas = Kelas::with(['DetailKelas' => function($query){
                            $query->where('id_user',Auth::user()->id)
                                    ->with(['Transaksi' => function($query_2){
                                        $query_2->where('status','!=','ditolak_admin')->where('status','!=','dibatalkan_user')->where('status','!=','expired_system');
                                    }])->whereHas('Transaksi',function($query_3){
                                        $query_3->where('status','!=','ditolak_admin')->where('status','!=','dibatalkan_user')->where('status','!=','expired_system');
                                    });
                }])->findOrFail($request->id_kelas);
                
                if($kelas->DetailKelas->isEmpty()){
                    throw new ModelNotFoundException;
                }

                if(!isset($kelas->DetailKelas[0]->Transaksi)){
                    throw new ModelNotFoundException;
                }
                
            }catch(ModelNotFoundException $err){
                return redirect()->route('user.pendaftaran')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan 2',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }

            // DELETE APABILA SUDAH ADA IMAGE SEBELUMNYA
                if($kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi != null){
                    Storage::delete('public\image_bukti_transaksi\\'.$kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi);
                }
            // SAVE IMAGE
                $nama_file = basename($request->file('file_bukti_pembayaran')->store('public/image_bukti_transaksi'));

            switch ($kelas->DetailKelas[0]->Transaksi->status) {
                case 'menunggu_pembayaran':
                    
                    $kelas->DetailKelas[0]->Transaksi->status = 'menunggu_konfirmasi';
                    $kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi = $nama_file;
                    $kelas->DetailKelas[0]->Transaksi->save();

                    break;
                case 'menunggu_konfirmasi':
                    $kelas->DetailKelas[0]->Transaksi->status = 'menunggu_konfirmasi';
                    $kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi = $nama_file;
                    $kelas->DetailKelas[0]->Transaksi->save();

                    break;
                default:
                    return redirect()->back()->with([
                        'status' => 'fail',
                        'icon' => 'error',
                        'title' => 'Selesaikan sesuai tahapan',
                        'message' => 'Mohon selesaikan sesuai tahapan'
                    ]);
                    break;
            }

            return redirect()->route('user.verifikasi.kelas',[Crypt::encryptString($kelas->id)]);
        // END
    }

    public function stepVerifikasi(Request $request){
        // DECRYPT
            try {
                $request->merge(['id_kelas' => Crypt::decryptString($request->id_kelas)]);
            } catch (DecryptException $e) {
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                ]);
            }
        // END

        // SECURITY
            $validator = Validator::make($request->all(),[
                'id_kelas' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas tidak ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem, apabila diperlukan silahkan hubungi admin sistem'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                $kelas = Kelas::with(['DetailKelas' => function($query){
                            $query->where('id_user',Auth::user()->id)
                                    ->with(['Transaksi' => function($query_2){
                                        $query_2->where('status','!=','ditolak_admin')->where('status','!=','dibatalkan_user')->where('status','!=','expired_system');
                                    }])->whereHas('Transaksi',function($query_3){
                                        $query_3->where('status','!=','ditolak_admin')->where('status','!=','dibatalkan_user')->where('status','!=','expired_system');
                                    });
                }])->findOrFail($request->id_kelas);
                
                if($kelas->DetailKelas->isEmpty()){
                    throw new ModelNotFoundException;
                }

                if(!isset($kelas->DetailKelas[0]->Transaksi)){
                    throw new ModelNotFoundException;
                }
                
            }catch(ModelNotFoundException $err){
                return redirect()->route('user.pendaftaran')->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'title' => 'Kelas Tidak Ditemukan 2',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }

            $encrypt_kelas_id = Crypt::encryptString($kelas->id);

            // CHECK APAKAH STATUS SUDAH MENUNGGU KONFIRMASI
                switch ($kelas->DetailKelas[0]->Transaksi->status) {
                    case 'menunggu_konfirmasi':
                        if($kelas->DetailKelas[0]->Transaksi->file_bukti_transaksi == null){
                            
                            $kelas->DetailKelas[0]->Transaksi->status = 'menunggu_pembayaran';
                            $kelas->DetailKelas[0]->Transaksi->save();

                            return redirect()->Route('user.upload.kelas',[$encrypt_kelas_id])->with([
                                'status' => 'fail',
                                'icon' => 'error',
                                'title' => 'Mohon Upload Bukti Transaksi Terlebih Dahulu',
                                'message' => 'Lakukan pembayaran sesuai dengan langkah-langkah yang telah diberikan'
                            ]);    
                        }else{
                            return view('user-dashboard.user-kelas-saya.user-verifikasi',compact(['kelas']));
                        }
                        break;
                    case 'memilih_metode_pembayaran':
                        return redirect()->Route('user.pembayaran.kelas',[$encrypt_kelas_id])->with([
                            'status' => 'fail',
                            'icon' => 'error',
                            'title' => 'Mohon Lakukan Pembayaran Sesuai Step',
                            'message' => 'Lakukan pembayaran sesuai dengan langkah-langkah yang telah diberikan'
                        ]);
                        break;
                    case 'menunggu_pembayaran':
                        return redirect()->Route('user.upload.kelas',[$encrypt_kelas_id])->with([
                            'status' => 'fail',
                            'icon' => 'error',
                            'title' => 'Mohon Upload Bukti Pembayaran Terlebih Dahulu',
                            'message' => 'Lakukan pembayaran sesuai dengan langkah-langkah yang telah diberikan'
                        ]);
                        break;
                    default:
                        return redirect()->back()->with([
                            'status' => 'fail',
                            'icon' => 'error',
                            'title' => 'Mohon Lakukan Pembayaran Sesuai Step',
                            'message' => 'Lakukan pembayaran sesuai dengan langkah-langkah yang telah diberikan'
                        ]);
                        break;
                }
            // END
        // END
    }
}
