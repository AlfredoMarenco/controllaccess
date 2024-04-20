<?php

namespace App\Http\Livewire\Admin;

use App\Models\Admin\Box;
use App\Models\Admin\Code;
use App\Models\Admin\Event;
use App\Models\Record;
use Livewire\Component;
use Livewire\WithPagination;

class AdministrationComponent extends Component
{

    use WithPagination;
    public $boxs_view=true;
    public $box_view=false;
    public $seat_view=false;
    public $add_view=false;
    public $add_box_modal=false;
    public $box;
    public $identifier;
    public $section;
    public $seat;
    public $barcode;
    public $boxes;
    public $box_name='';
    public $box_identifier='';
    public $name_box;
    public $identifier_box;

    public $seatEdit = [
        'id'=> '',
        'name' => '',
        'identifier' => '',
        'seat' => '',
        'barcode' => '',
        'status' => ''
    ];
    /* public $rules = [
        'seatEdit.barcode' => 'unique'
    ]; */

    protected $messages = [
        'barcode.unique' => 'Este código ya fue asignado a una tarjeta'
    ];

    public $listeners = ['deleteSeat'];


    public function addBox(){
        Box::create([
            'name' => $this->name_box,
            'identifier' => $this->identifier_box
        ]);
        $this->reset('name_box','identifier_box','add_box_modal');
    }

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
        $this->seatEdit['status'] = $code->status;
        $this->resetErrorBag();
    }

    public function showAdd(){
        $this->add_view = true;
        $this->identifier = $this->box->identifier;
        $this->name = $this->box->name;
        $this->resetErrorBag();
        $this->reset('barcode');
    }

    public function restartDataBase(){
        $event = Event::create([
            'name' => $this->event_name,
            'code' => $this->event_code
        ]);
        $codes = Code::all();
        foreach ($codes as $code) {
            Record::create([
                'barcode' => $code->barcode,
                'name' => $code->name,
                'row' => $code->row,
                'seat' => $code->seat,
                'status' => $code->status,
                'event_id' => $event->id,
                //'updated_at' => $code->updated_at,
                'box_id' => $code->box_id
            ]);
        }
        foreach ($codes as $code) {
            $code->update([
                'status' => '1'
            ]);
        }
        session()->flash('message', 'Base de datos restaurada.');
        $this->reset('event_name','event_code');
        $this->modal_restDataBase = false;
    }

    public function addCode(){
        $this->validate([
            'barcode' => 'required|unique:codes',
            'seat' => 'required|max:2',
            'status' => 'required'
        ]);
        $code = Code::create([
            'barcode' => $this->barcode,
            'section' => $this->name,
            'row' => $this->identifier,
            'seat' => $this->seat,
            'status' => $this->status,
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
            'barcode' => 'required|unique:codes,barcode,'.$id,
        ];
        $code = Code::find($id);
        $this->validate($rules);
        $code->barcode = $this->seatEdit['barcode'];
        $code->status = $this->seatEdit['status'];
        $code->save();
        $this->box = Box::find($this->box->id);
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

    public function mount(){
        $this->boxes_names = Box::distinct('name')->get();
        $this->boxes_identifiers = Box::distinct('identifier')->get();
    }

    public function render()
    {
        if ($this->box_name && $this->box_identifier) {
            $boxs = Box::where('name',$this->box_name)->where('identifier',$this->box_identifier)->paginate();
        }
        if (!$this->box_name && $this->box_identifier) {
            $boxs = Box::where('identifier',$this->box_identifier)->paginate();
        }
        if ($this->box_name && !$this->box_identifier) {
            $boxs = Box::where('name',$this->box_name)->paginate();
        }
        if ($this->box_name == "" && $this->box_identifier == "") {
            $boxs = Box::paginate();
        }

        return view('livewire.admin.administration-component',compact('boxs'));
    }
}
