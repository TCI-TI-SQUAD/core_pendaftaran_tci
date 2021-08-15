<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;

use App\User;

class RegisterHariIniComponent extends Component
{
    public $users;
    
    public function render()
    {
        $this->users = User::get(['name','username','hsk','nomor_pelajar_tci'])->toArray();
        
        return view('livewire.admin.dashboard.register-hari-ini-component');
    }
}
