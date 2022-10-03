<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Box;
use Livewire\Component;

class AdministrationComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.administration-component',[
            'boxs' => Box::paginate()
        ]);
    }
}
