<?php

namespace App\Http\Controllers\admin\pendaftaran_kelas\kelas\peserta_kelas;

use App\DetailKelas;
use App\Http\Controllers\Controller;
use App\Kelas;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use PDOException;

class PesertaKelasController extends Controller
{
    public function index(Request $request){
        // SEUCIRITY
            $validator = Validator::make(['id' => $request->id],[
                'id' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'titile' => 'Kelas Tidak Ditemukan 1',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // MAIN LOGIC
            try{
                
                $kelas = Kelas::with("Pendaftaran")->findOrFail($request->id);
                $pendaftaran = $kelas->Pendaftaran;

            }catch(ModelNotFoundException | PDOException | QueryException | \Throwable | \Exception $err){
                return redirect()->back()->with([
                    'status' => 'fail',
                    'icon' => 'error',
                    'titile' => 'Kelas Tidak Ditemukan',
                    'message' => 'Kelas tidak ditemukan di dalam sistem'
                ]);
            }
        // END

        // RETURN
            return view('admin.admin.pendaftaran_kelas.kelas.kelas_peserta.kelas-peserta-index',compact(['kelas','pendaftaran']));
        // END
    }

    public function ajaxPesertaKelasData(Request $request){
        // SECURITY
            $validator = Validator::make($request->all(),[
                'id' => 'required|exists:kelas,id',
            ]);

            if($validator->fails()){
                return abort(403,"Unathorized Action");
            }
        // END

        // MAIN LOGIC
            try{
                // FILTER TRANSAKSI
                $transaksi_filter = function($transaksi_query){
                    $transaksi_query->where('status','!=','dibatalkan_user')
                                    ->orWhere('status','!=','expired_system')
                                    ->orWhere('status','!=','ditolak_admin');
                };
            
                $detail_kelas = json_encode(["data" => DetailKelas::with([
                                                    'Transaksi' => $transaksi_filter,
                                                    'User'
                                                ])->whereHas('Transaksi',$transaksi_filter)
                                                ->whereHas('User')
                                                ->whereHas('Kelas')
                                                ->where('id_kelas',$request->id)
                                                ->get()
                                                ->map(function($value,$index){
                                                    $value['number'] = $index+=1;
                                                    return $value;
                                                })
                                            ]);
                
            }catch(ModelNotFoundException | PDOException | QueryException |\Throwable | \Exception $err){
                return abort(500,"Server Error");
            }
        // END

        // RETURN
            return $detail_kelas;
        // END
    }
}
