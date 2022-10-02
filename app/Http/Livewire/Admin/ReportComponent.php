<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Code;
use Livewire\Component;

class ReportComponent extends Component
{
    public function render()
    {
        return view('livewire.admin.report-component',[
            'palcos' => Code::where('section','PLATINO')->distinct('row')->get(),
            'boxs' => Code::all(),
        ]);
    }
}
