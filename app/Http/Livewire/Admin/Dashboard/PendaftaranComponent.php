<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;

use App\Pendaftaran;

class PendaftaranComponent extends Component
{
    public function render()
    {
        $pendaftaran = Pendaftaran::whereDate('tanggal_mulai_pendaftaran','<',date('Y-m-d'))->whereDate('tanggal_selesai_pendaftaran','>',date('Y-m-d'))->count();

        return view('livewire.admin.dashboard.pendaftaran-component',compact(['pendaftaran']));
    }
}
