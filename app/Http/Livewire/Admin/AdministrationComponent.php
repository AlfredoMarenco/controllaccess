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
    public $add_view=false;
    public $box;
    public $identifier;
    public $section;
    public $seat;
    public $barcode;

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

    protected $messages = [
        'barcode.unique' => 'Este código ya fue asignado a una tarjeta'
    ];

    public $listeners = ['deleteSeat'];

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
        $this->resetErrorBag();
    }

    public function showAdd(){
        $this->add_view = true;
        $this->identifier = $this->box->identifier;
        $this->name = $this->box->name;
        $this->resetErrorBag();
        $this->reset('barcode');
    }

    public function addCode(){
        $this->validate([
            'barcode' => 'unique:codes',
            'seat' => 'required',
        ]);
        $code = Code::create([
            'barcode' => $this->barcode,
            'section' => $this->name,
            'row' => $this->identifier,
            'seat' => $this->seat,
            'status' => 1,
            'event_id' => 1,
            'box_id' => $this->box->id

        ]);
        $this->reset('barcode','seat');
        $this->box = Box::find($this->box->id);
        $this->resetErrorBag();
        $this->add_view = false;
    }
    public function updateSeat($id){
        $this->barcode = $this->seatEdit['barcode'];
        $rules = [
            'barcode' => 'required|unique:codes,barcode,'.$id
        ];
        $code = Code::find($id);
        $this->validate($rules);
        $code->barcode = $this->seatEdit['barcode'];
        $code->save();
        $this->reset('seatEdit');
        $this->resetErrorBag();
        $this->seat_view = false;
    }

    public function deleteSeat($id){
        $code = Code::find($id);
        $code->delete();
        $this->box = Box::find($this->box->id);
        $this->seat_view = false;
    }

    public function render()
    {
        return view('livewire.admin.administration-component',[
            'boxs' => Box::paginate()
        ]);
    }
}
