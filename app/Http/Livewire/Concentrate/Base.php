<?php

namespace App\Http\Livewire\Concentrate;

use App\Models\Concentrate;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $concentrateId;
    public $search;
    public $boton_activo;

    protected $listeners = ['render','anuladoConfirmado'];

    public function mount(){
        $this->search = "";
        $this->concentrateId = 0;
        $this->boton_activo = false;
    }

    public function seleccionar($id) {
        $this->concentrateId = $id;
    }

    public function anular(){
        if(Concentrate::has('orders')->where('id',$this->concentrateId)->exists()){
            $this->alert('warning', '¡No se puede eliminar el concentrado!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->alert('question','¿Estas seguro de eliminar?',[
                'showConfirmButton' => true,
                'confirmButtonText' => 'Sí',
                'position' => 'center',
                'toast' => false,
                'showCancelButton' => true,
                'cancelButtonText' => 'No',
                'timer' => 10000,
                'onConfirmed' => 'anuladoConfirmado',
            ]);

        }
    }
    public function anuladoConfirmado() {
        Concentrate::find($this->concentrateId)->delete();
        $this->concentrateId = 0;
        $this->alert('success', '¡Concentrado Eliminado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
        ]);
        $this->render();
    }

    public function getConcentrates(){
        $concentrates = Concentrate::when($this->search != "", function($q){
            return $q->where('concentrate','like','%'.$this->search.'%')->orWhere('chemical_symbol','like','%'.$this->search.'%');
        })->paginate(6);
        return $concentrates;
    }

    public function render()
    {
        $this->boton_activo = $this->concentrateId > 0;
        $concentrates = $this->getConcentrates();
        return view('livewire.concentrate.base',compact('concentrates'));
    }
}
