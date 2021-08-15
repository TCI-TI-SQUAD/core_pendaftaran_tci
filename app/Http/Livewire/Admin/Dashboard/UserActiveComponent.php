<?php

namespace App\Http\Livewire\Admin\Dashboard;

use Livewire\Component;
use App\User;


class UserActiveComponent extends Component
{
    public function render()
    {
        $active_user = User::where('hak_akses','aktif')->count();
        return view('livewire.admin.dashboard.user-active-component',compact(['active_user']));
    }
}
