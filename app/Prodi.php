<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Prodi extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'id_fakultas',
        'nama_prodi',
        'keterangan',
    ];

    protected $casts = [
        'id' => EncryptCast::class,
        'id_fakultas' => EncryptCast::class,
    ];

    public function getFullProdiName(){
        $fakultas = $this->Fakultas()->first();
        $universitas = $fakultas->Universitas()->first();

        return $this->nama_prodi.", ".$fakultas->nama_fakultas.", ".$universitas->nama_universitas;
    }

    public function Fakultas(){
        return $this->belongsTo('App\Fakultas','id_fakultas','id');
    }
}
