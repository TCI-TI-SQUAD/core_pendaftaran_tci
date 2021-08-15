<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Pendaftaran;

class CountdownPengumumanComponent extends Component
{
    public $pendaftarans;
    public $jam;

    public function mount(){
        // GET ALL PENDAFTARAN
        $this->pendaftarans = Pendaftaran::where('status','aktif')
                                    ->where('tanggal_mulai_pendaftaran','<=',date('Y-m-d H:i:s'))
                                    ->where('tanggal_selesai_pendaftaran','>',date("Y-m-d H:i:s"))
                                    ->get()->toArray();
        // JAM
        $this->jam = date('H');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.countdown-pengumuman-component');
    }
}
