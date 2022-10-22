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
        $this->boxs = $barcode->where('box_id',$barcode->box_id)->get();
            switch ($barcode->status) {
                case '0':
                    if ($this->type==1) {
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'CODIGO YA INGRESADO',
                            'html' => 'ALTO - TARJETA YA INGRESADA <br> <small>'.$barcode->updated_at.'</small>',
                            'icon' => 'error',
                            'timer' => 2500,
                        ]);
                    } else {
                        if (!$barcode->status == 1) {
                            $this->dispatchBrowserEvent('valid',[
                                'title' => 'SALIDA ASIGNADA',
                                'html' => 'TARJETA REINICIADA PARA REINGRESO',
                                'icon' => 'success',
                                'timer' => 1300,
                            ]);
                            $barcode->update([
                                'status' => "2",
                            ]);
                        }else{
                            $this->dispatchBrowserEvent('valid',[
                                'title' => 'LA TARJETA NO A INGRESADO',
                                'html' => 'ESTA TARJETA NO HA INGRESADO',
                                'icon' => 'warning',
                                'timer' => 2500,
                            ]);
                        }
                    }

                    $this->boxs = $barcode->where('box_id',$barcode->box_id)->get();
                    $this->reset('barcode');
                    break;
                case '1':
                    if ($this->type == 1) {
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'CODIGO VALIDO',
                            'html' => 'PASE',
                            'icon' => 'success',
                            'timer' => 1300,
                        ]);
                        $barcode->update([
                            'status' => "0",
                        ]);
                    }else{
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'LA TARJETA NO A INGRESADO',
                            'html' => 'ESTA TARJETA NO HA INGRESADO',
                            'icon' => 'warning',
                            'timer' => 2500,
                        ]);
                    }
                    $this->boxs = $barcode->where('box_id',$barcode->box_id)->get();
                    $this->reset('barcode');
                    break;
                case '2':
                    if ($this->type == 1) {
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'CODIGO VALIDO',
                            'html' => 'PASE - TARJETA DE REINGRESO',
                            'icon' => 'success',
                            'timer' => 1300,
                        ]);
                        $barcode->update([
                            'status' => "0",
                        ]);

                    }else{
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'NO SE LE PUEDE ASIGNAR SALIDA',
                            'html' => 'YA CUENTA CON UNA SALIDA ASIGNADA',
                            'icon' => 'warning',
                            'timer' => 2500,
                        ]);
                    }
                    $this->boxs = $barcode->where('box_id',$barcode->box_id)->get();
                    $this->reset('barcode');
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
