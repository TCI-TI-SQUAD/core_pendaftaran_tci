<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\Transaksi;

class TransaksiMenungguKonfirmasiComponent extends Component
{
    public function render()
    {
        $transaksi_menunggu_konfirmasi = Transaksi::where('status','menunggu_konfirmasi')->count();

        return view('livewire.admin.dashboard.transaksi-menunggu-konfirmasi-component',compact(['transaksi_menunggu_konfirmasi']));
    }
}
