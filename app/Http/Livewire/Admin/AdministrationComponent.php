<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Box;
use App\Models\Admin\Code;
use Livewire\Component;

class AdministrationComponent extends Component
{
    public $boxs_view=true;
    public $box_view=false;
    public $seat_view=false;
    public $box;
    public $seat;
    public $seatEdit = [
        'id'=> '',
        'name' => '',
        'identifier' => '',
        'seat' => '',
        'barcode' => ''
    ];
    /* public $rules = [
        'seatEdit.barcode' => 'unique'
    ]; */


    public function showBox(Box $box){
        $this->box_view = true;
        $this->boxs_view=false;
        $this->box = $box;
    }

    public function showSeat(Code $code){
        $this->seat_view = true;
        $this->seatEdit['id'] = $code->id;
        $this->seatEdit['name'] = $code->box->name;
        $this->seatEdit['identifier'] = $code->box->identifier;
        $this->seatEdit['seat'] = $code->seat;
        $this->seatEdit['barcode'] = $code->barcode;
    }

    public function updateSeat($id){
        $rules = [
            'seatEdit.barcode' => 'unique:codes'
        ];
        $code = Code::find($id);
        $this->validate($rules);
        $code->barcode = $this->seatEdit['barcode'];
        $code->save();
        $this->reset('seatEdit');
        $this->seat_view = false;
    }

    public function render()
    {
        return view('livewire.admin.administration-component',[
            'boxs' => Box::paginate()
        ]);
    }
}
