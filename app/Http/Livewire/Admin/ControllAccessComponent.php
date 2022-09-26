<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Code;
use Livewire\Component;

class ControllAccessComponent extends Component
{

    public $barcode;
    public $type=1;
    public $boxs;

    public function valid(){

        $barcode = Code::where('barcode', $this->barcode)->first();
        if ($barcode) {
        $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get();
            switch ($barcode->status) {
                case '1':
                    $this->dispatchBrowserEvent('valid',[
                        'title' => 'CODIGO VALIDO',
                        'html' => 'PASE',
                        'icon' => 'success',
                        'timer' => 1300,
                    ]);
                    $this->reset('barcode');
                    break;

                default:
                    # code...
                    break;
            }
        }else{
            $this->dispatchBrowserEvent('valid',[
                'title' => 'CODIGO INVALIDO',
                'html' => 'ALTO - REVISAR TARJETA',
                'icon' => 'error',
                'timer' => 2000,
            ]);
            $this->reset('barcode');
        }
    }

    public function render()
    {

        return view('livewire.admin.controll-access-component');
    }
}
