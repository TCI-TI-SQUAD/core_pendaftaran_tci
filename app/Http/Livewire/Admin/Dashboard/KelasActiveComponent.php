<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Kelas;

class KelasActiveComponent extends Component
{
    public function render()
    {
        $pendaftaran_filter = function($query_pendaftaran){
            $query_pendaftaran->whereDate('tanggal_mulai_pendaftaran','<',date('Y-m-d'))->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))
                                ->where('status','aktif');
        };

        $kelas_active = Kelas::whereHas('Pendaftaran',$pendaftaran_filter)->count();

        return view('livewire.admin.dashboard.kelas-active-component',compact(['kelas_active']));
    }
}
