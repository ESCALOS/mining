<?php

namespace App\Http\Livewire\Settlement;

use App\Models\Settlement;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $settlementId;
    public $search;
    public $boton_activo;

    protected $listeners = ['render','anuladoConfirmado'];

    public function mount(){
        $this->search = "";
        $this->settlementId = 0;
        $this->boton_activo = false;
    }

    public function getSettlements(){
        $settlements = Settlement::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->paginate(6);
        return $settlements;
    }

    public function seleccionar($id) {
        $this->settlementId = $id;
    }
    public function render()
    {
        $this->boton_activo = $this->settlementId > 0;
        $settlements = $this->getSettlements();

        return view('livewire.settlement.base',compact('settlements'));
    }
}
