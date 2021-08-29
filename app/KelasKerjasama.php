<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class KelasKerjasama extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_kelas',
        'id_instansi',
        'status',
    ];

    public function Instansi(){
        switch ($this->status) {
            case 'umum':
                return $this->belongsTo("App\Umum","id_instansi",'id');
                break;
            
            case 'siswa':
                return $this->belongsTo("App\Sekolah","id_instansi","id");
                break;

            case 'mahasiswa':
                return $this->belongsTo('App\Prodi','id_instansi','id');
                break;

            case 'instansi':
                return $this->belongsTo("App\Instansi","id_instansi","id");
                break;
            default:
                return null;
                break;
        }
    }

    public function getInstansiName(){
        switch ($this->status) {
            case 'umum':
                return "Umum";
                break;
            
            case 'siswa':
                return $this->belongsTo("App\Sekolah","id_instansi","id")->first()->nama_sekolah;
                break;

            case 'mahasiswa':
                $instansi = $this->belongsTo('App\Prodi','id_instansi','id')->first()->nama_prodi;
                $instansi .= ", ".$this->belongsTo('App\Prodi','id_instansi','id')->first()->Fakultas->nama_fakultas;
                $instansi .= ", ".$this->belongsTo('App\Prodi','id_instansi','id')->first()->Fakultas->Universitas->nama_universitas;
                return $instansi;
                break;

            case 'instansi':
                return $this->belongsTo("App\Instansi","id_instansi","id")->first()->nama_instansi;
                break;
            default:
                return null;
                break;
        }
    }
}
