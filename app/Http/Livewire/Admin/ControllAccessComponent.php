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
        if ($barcode){
        $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get();
            if (auth()->user()->filter == 1) {

                //Validaciones para el filtro de acceso principal del recinto
                switch ($barcode->status) {
                    case '0': //Codigo ya ingresado
                        if ($this->type==1) { // Ingreso o salida
                            $this->dispatchBrowserEvent('valid',[ //Rechaza por intento de reingreso
                                'title' => 'CODIGO YA INGRESADO',
                                'html' => 'ALTO - TARJETA YA INGRESADA <br> <small>'.$barcode->updated_at.'</small>',
                                'icon' => 'error',
                                'timer' => 2500,
                            ]);
                        } else {
                            if ($barcode->status == 0) { // Otorgar salida si ya ingreso
                                $this->dispatchBrowserEvent('valid',[
                                    'title' => 'SALIDA ASIGNADA',
                                    'html' => 'TARJETA REINICIADA PARA REINGRESO',
                                    'icon' => 'success',
                                    'timer' => 1300,
                                ]);
                                $barcode->update([
                                    'status' => "2", //status de salida
                                ]);
                            }else{
                                //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                $this->dispatchBrowserEvent('valid',[
                                    'title' => 'LA TARJETA NO A INGRESADO',
                                    'html' => 'ESTA TARJETA NO HA INGRESADO',
                                    'icon' => 'warning',
                                    'timer' => 2500,
                                ]);
                            }
                        }

                        $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); //informacion del palco para mostrar en la interfaz
                        $this->reset('barcode');
                        break;
                    case '1'://Codigo no ingresado
                        if ($this->type == 1) { // Ingreso o salida
                        // Mensaje de codigo aceptado
                            if ($barcode->status2 == 1) { // Otorgar salida si ya ingreso
                                $this->dispatchBrowserEvent('valid',[
                                    'title' => 'CODIGO VALIDO',
                                    'html' => 'PASE',
                                    'icon' => 'success',
                                    'timer' => 1300,
                                ]);
                                $barcode->update([
                                    'status' => "0", //status de salida
                                    'updated2' => now(),

                                ]);
                            }else{
                                //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                $this->dispatchBrowserEvent('valid',[
                                    'title' => 'LA TARJETA USADA INTERNAMENTE',
                                    'html' => 'ESTA TARJETA SE USO EN FILTRO INTERNO',
                                    'icon' => 'warning',
                                    'timer' => 2500,
                                ]);
                            }
                        }else{
                            //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                            $this->dispatchBrowserEvent('valid',[
                                'title' => 'LA TARJETA NO A INGRESADO',
                                'html' => 'ESTA TARJETA NO HA INGRESADO',
                                'icon' => 'warning',
                                'timer' => 2500,
                            ]);
                        }
                        $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); // Informacion del palco para mostrar en la interfaz
                        $this->reset('barcode');
                        break;
                    case '2':
                        if ($this->type == 1) {// Ingreso o salida
                            //Si el codigo ya habia salido le damos el reingreso
                            $this->dispatchBrowserEvent('valid',[
                                'title' => 'CODIGO VALIDO',
                                'html' => 'PASE - TARJETA DE REINGRESO',
                                'icon' => 'success',
                                'timer' => 1300,
                            ]);
                            $barcode->update([
                                'status' => "0", // Cambio de estatus a usado nuevamente
                            ]);

                        }else{
                            //Mensaje de que la tarjeta ya fue utilizada para salir
                            $this->dispatchBrowserEvent('valid',[
                                'title' => 'NO SE LE PUEDE ASIGNAR SALIDA',
                                'html' => 'YA CUENTA CON UNA SALIDA ASIGNADA',
                                'icon' => 'warning',
                                'timer' => 2500,
                            ]);
                        }
                        $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get();
                        $this->reset('barcode');
                        break;
                }
            }else{
                //Validaciones para el filtro 2 del recinto
                if (auth()->user()->filter == 2) {
                    if ($barcode->section == 'PLATINO') {
                        switch ($barcode->status2) {
                            case '0': //Codigo ya ingresado
                                if ($this->type==1) { // Ingreso o salida
                                    $this->dispatchBrowserEvent('valid',[ //Rechaza por intento de reingreso
                                        'title' => 'CODIGO YA INGRESADO',
                                        'html' => 'ALTO - TARJETA YA INGRESADA <br> <small>'.$barcode->updated2_at.'</small>',
                                        'icon' => 'error',
                                        'timer' => 2500,
                                    ]);
                                } else {
                                    if ($barcode->status2 == 0) { // Otorgar salida si ya ingreso
                                        $this->dispatchBrowserEvent('valid',[
                                            'title' => 'SALIDA ASIGNADA',
                                            'html' => 'TARJETA REINICIADA PARA REINGRESO',
                                            'icon' => 'success',
                                            'timer' => 1300,
                                        ]);
                                        $barcode->update([
                                            'status2' => "2", //status de salida
                                            'updated2' => now(),

                                        ]);
                                    }else{
                                        //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                        $this->dispatchBrowserEvent('valid',[
                                            'title' => 'LA TARJETA NO A INGRESADO',
                                            'html' => 'ESTA TARJETA NO HA INGRESADO',
                                            'icon' => 'warning',
                                            'timer' => 2500,
                                        ]);
                                    }
                                }

                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); //informacion del palco para mostrar en la interfaz
                                $this->reset('barcode');
                                break;
                            case '1'://Codigo no ingresado
                                if ($this->type == 1) { // Ingreso o salida
                                // Mensaje de codigo aceptado
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'CODIGO VALIDO',
                                        'html' => 'PASE',
                                        'icon' => 'success',
                                        'timer' => 1300,
                                    ]);
                                    $barcode->update([
                                        'status2' => "0", // Cambio de estatus a ya iongresado
                                        'updated2' => now(),
                                    ]);
                                }else{
                                    //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'LA TARJETA NO A INGRESADO',
                                        'html' => 'ESTA TARJETA NO HA INGRESADO',
                                        'icon' => 'warning',
                                        'timer' => 2500,
                                    ]);
                                }
                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); // Informacion del palco para mostrar en la interfaz
                                $this->reset('barcode');
                                break;
                            case '2':
                                if ($this->type == 1) {// Ingreso o salida
                                    //Si el codigo ya habia salido le damos el reingreso
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'CODIGO VALIDO',
                                        'html' => 'PASE - TARJETA DE REINGRESO',
                                        'icon' => 'success',
                                        'timer' => 1300,
                                    ]);
                                    $barcode->update([
                                        'status2' => "0", // Cambio de estatus a usado nuevamente
                                        'updated2' => now(),
                                    ]);

                                }else{
                                    //Mensaje de que la tarjeta ya fue utilizada para salir
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'NO SE LE PUEDE ASIGNAR SALIDA',
                                        'html' => 'YA CUENTA CON UNA SALIDA ASIGNADA',
                                        'icon' => 'warning',
                                        'timer' => 2500,
                                    ]);
                                }
                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get();
                                $this->reset('barcode');
                                break;
                        }
                        } else {
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'CODIGO INVALIDO',
                            'html' => 'ALTO - REVISAR TARJETA',
                            'icon' => 'error',
                            'timer' => 2000,
                        ]);
                        $this->reset('barcode');
                    }
                } else {
                    if ($barcode->section == 'ORO') {
                        switch ($barcode->status2) {
                            case '0': //Codigo ya ingresado
                                if ($this->type==1) { // Ingreso o salida
                                    $this->dispatchBrowserEvent('valid',[ //Rechaza por intento de reingreso
                                        'title' => 'CODIGO YA INGRESADO',
                                        'html' => 'ALTO - TARJETA YA INGRESADA <br> <small>'.$barcode->updated2_at.'</small>',
                                        'icon' => 'error',
                                        'timer' => 2500,
                                    ]);
                                } else {
                                    if ($barcode->status2 == 0) { // Otorgar salida si ya ingreso
                                        $this->dispatchBrowserEvent('valid',[
                                            'title' => 'SALIDA ASIGNADA',
                                            'html' => 'TARJETA REINICIADA PARA REINGRESO',
                                            'icon' => 'success',
                                            'timer' => 1300,
                                        ]);
                                        $barcode->update([
                                            'status2' => "2", //status de salida
                                            'updated2' => now(),

                                        ]);
                                    }else{
                                        //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                        $this->dispatchBrowserEvent('valid',[
                                            'title' => 'LA TARJETA NO A INGRESADO',
                                            'html' => 'ESTA TARJETA NO HA INGRESADO',
                                            'icon' => 'warning',
                                            'timer' => 2500,
                                        ]);
                                    }
                                }

                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); //informacion del palco para mostrar en la interfaz
                                $this->reset('barcode');
                                break;
                            case '1'://Codigo no ingresado
                                if ($this->type == 1) { // Ingreso o salida
                                // Mensaje de codigo aceptado
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'CODIGO VALIDO',
                                        'html' => 'PASE',
                                        'icon' => 'success',
                                        'timer' => 1300,
                                    ]);
                                    $barcode->update([
                                        'status2' => "0", // Cambio de estatus a ya iongresado
                                        'updated2' => now(),
                                    ]);
                                }else{
                                    //Mensaje de que la tarjeta no ha sido ingresada previamente y no se puede otorgar la salida
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'LA TARJETA NO A INGRESADO',
                                        'html' => 'ESTA TARJETA NO HA INGRESADO',
                                        'icon' => 'warning',
                                        'timer' => 2500,
                                    ]);
                                }
                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get(); // Informacion del palco para mostrar en la interfaz
                                $this->reset('barcode');
                                break;
                            case '2':
                                if ($this->type == 1) {// Ingreso o salida
                                    //Si el codigo ya habia salido le damos el reingreso
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'CODIGO VALIDO',
                                        'html' => 'PASE - TARJETA DE REINGRESO',
                                        'icon' => 'success',
                                        'timer' => 1300,
                                    ]);
                                    $barcode->update([
                                        'status2' => "0", // Cambio de estatus a usado nuevamente
                                        'updated2' => now(),
                                    ]);

                                }else{
                                    //Mensaje de que la tarjeta ya fue utilizada para salir
                                    $this->dispatchBrowserEvent('valid',[
                                        'title' => 'NO SE LE PUEDE ASIGNAR SALIDA',
                                        'html' => 'YA CUENTA CON UNA SALIDA ASIGNADA',
                                        'icon' => 'warning',
                                        'timer' => 2500,
                                    ]);
                                }
                                $this->boxs = $barcode->where('row',$barcode->row)->where('section',$barcode->section)->get();
                                $this->reset('barcode');
                                break;
                        }
                        } else {
                        $this->dispatchBrowserEvent('valid',[
                            'title' => 'CODIGO INVALIDO',
                            'html' => 'ALTO - REVISAR TARJETA',
                            'icon' => 'error',
                            'timer' => 2000,
                        ]);
                        $this->reset('barcode');
                    }
                }

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
