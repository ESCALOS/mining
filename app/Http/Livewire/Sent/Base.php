<?php

namespace App\Http\Livewire\Sent;

use App\Models\Dispatch;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $dispatchId;
    public $search;

    protected $listeners = ['unship','render'];

    public function mount(){
        $this->dispatchId = 0;
        $this->search = "";
    }

    public function getDispatches(){
        $dispatches = Dispatch::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->withSum('details','wmt')->where('shipped',1)->latest()->paginate(10);
        return $dispatches;
    }

    public function confirmUnship($id){
        $this->dispatchId = $id;
        $this->alert('question','¿Estas seguro de regresar al despacho?',[
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'onConfirmed' => 'confirmed',
            'position' => 'center',
            'toast' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'timer' => 10000,
            'onConfirmed' => 'unship',
        ]);
    }

    public function unship(){
        $dispatch = Dispatch::find($this->dispatchId);
        $dispatch->shipped = false;
        $dispatch->save();
        $this->alert('success', 'Regresado a despacho!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => false,
        ]);
    }

    public function render()
    {
        $dispatches = $this->getDispatches();
        return view('livewire.sent.base',compact('dispatches'));
    }
}
