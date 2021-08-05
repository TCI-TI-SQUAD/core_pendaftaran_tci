<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_instansi','hsk','status','name','nomor_pelajar_tci','username','password','email','phone_number','line','wa','alamat','user_profile_pict','kartu_identitas','email_verified_at','hak_akses','jenis_kartu_identitas',
        'favorite'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function DetailKelas(){
        return $this->hasMany('App\DetailKelas','id_user','id');
    }

    public function getInstansiName(){
        switch($this->status){
            case 'mahasiswa':
                $instansi = $this->belongsTo('App\Prodi','id_instansi','id')->first()->nama_prodi;
                $instansi .= ", ".$this->belongsTo('App\Prodi','id_instansi','id')->first()->Fakultas->nama_fakultas;
                $instansi .= ", ".$this->belongsTo('App\Prodi','id_instansi','id')->first()->Fakultas->Universitas->nama_universitas;
                return $instansi;
            case 'siswa':
                return $this->belongsTo('App\Sekolah','id_instansi','id')->first()->nama_sekolah;
            case 'instansi':
                return $this->belongsTo('App\Instansi','id_instansi','id')->first()->nama_instansi;
            case 'umum':
                return $this->belongsTo('App\Instansi','id_instansi','id')->first()->nama_instansi;
        }
    }
}
