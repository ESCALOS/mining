<?php

namespace App\Http\Livewire\Dispatch;

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

    protected $listeners = ['confirmShip','ship'];

    public function mount(){
        $this->dispatchId = 0;
        $this->search = "";
    }

    public function confirmShip($id){
        $this->dispatchId = $id;
        $this->alert('question','¿Estas seguro de enviar?',[
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'onConfirmed' => 'confirmed',
            'position' => 'center',
            'toast' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'timer' => 10000,
            'onConfirmed' => 'ship',
        ]);
    }

    public function ship(){
        $dispatch = Dispatch::find($this->dispatchId);
        $dispatch->shipped = true;
        $dispatch->save();
        $this->emit('cerrarModal');
        $this->alert('success', '¡Enviado!', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => false,
        ]);
    }

    public function getDispatches(){
        $dispatches = Dispatch::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->withSum('details','wmt')->latest()->paginate(6);
        return $dispatches;
    }

    public function render()
    {
        $dispatches = $this->getDispatches();

        return view('livewire.dispatch.base',compact('dispatches'));
    }
}
