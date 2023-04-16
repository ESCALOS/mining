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

    protected $listeners = ['abrirModal','cerrarModal'];

    public function mount(){
        $this->open = false;
        $this->dispatchId = 0;
        $this->shipped = true;
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
