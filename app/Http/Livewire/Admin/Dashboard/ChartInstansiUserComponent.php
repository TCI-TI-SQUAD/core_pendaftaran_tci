<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;

use App\User;

class ChartInstansiUserComponent extends Component
{
    public $dataset;

    protected $listeners = [
        'test'
    ];

    public function render()
    {
        $user = User::get('status');

        $this->dataset = \json_encode([
            $user->where('status','umum')->count(),
            $user->where('status','siswa')->count(),
            $user->where('status','mahasiswa')->count(),
            $user->where('status','instansi')->count(),
        ]);
        
        return view('livewire.admin.dashboard.chart-instansi-user-component');
    }

    public function test(){

    }
}
