<?php

namespace App\Http\Livewire\Dispatch;

use App\Models\Dispatch;
use App\Models\DispatchDetail;
use Livewire\Component;

class DetailModal extends Component
{
    public $open;
    public $dispatchId;
    public $shipped;
    public $wmt_total;
    public $amount_total;
    public $dnwmt_total;
    public $copper_total;
    public $silver_total;
    public $gold_total;

    protected $listeners = ['abrirModal','cerrarModal'];

    public function mount(){
        $this->open = false;
        $this->dispatchId = 0;
        $this->shipped = true;
        $this->wmt_total = 0;
        $this->amount_total = 0;
        $this->dnwmt_total = 0;
        $this->copper_total = 0;
        $this->silver_total = 0;
        $this->gold_total = 0;
    }

    public function abrirModal($id){
        $this->dispatchId = $id;
        $this->shipped = Dispatch::find($id)->shipped;
        $this->open = true;
    }

    public function cerrarModal(){
        $this->open = false;
    }

    public function render()
    {
        $dispatchDetails = DispatchDetail::where('dispatch_id',$this->dispatchId)->get();

        return view('livewire.dispatch.detail-modal',compact('dispatchDetails'));
    }
}
