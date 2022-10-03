<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Box;
use Livewire\Component;

class ReportComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.report-component',[
            'boxs' => Box::all(),
        ]);
    }
}
