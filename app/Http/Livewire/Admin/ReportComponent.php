<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Box;
use Livewire\Component;

class ReportComponent extends Component
{
    public $principal = true;
    public $interior = false;

    public function showPrincipal()
    {
        $this->principal = true;
        $this->interior = false;
    }

    public function showInterior()
    {
        $this->principal = false;
        $this->interior = true;
    }
    public function render()
    {


        return view('livewire.admin.report-component', [
            'boxs' => Box::all(),
        ]);
    }
}
