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

    protected $listeners = ['render'];

    public function mount(){
        $this->search = "";
        $this->settlementId = [];
        $this->boton_activo = false;
    }

    public function getSettlements(){
        $settlements = Settlement::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->join('orders','orders.id','settlements.order_id')
        ->join('entities','entities.id','orders.client_id')
        ->join('concentrates','concentrates.id','orders.concentrate_id')
        ->select('settlements.id','settlements.batch','concentrates.concentrate','settlements.order_id','orders.wmt','entities.name')->orderBy('id','DESC')->paginate(6);
        return $settlements;
    }

    public function seleccionar($id) {
        if(!in_array($id,$this->settlementId)){
            array_push($this->settlementId,$id);
        }else{
            array_splice($this->settlementId,array_search($id,$this->settlementId),1);
        }
    }

    public function abrirSettleModal($settlement,$order){
        $this->alert('info', '¡Cargando...!', [
            'position' => 'center',
            'timer' => null,
            'toast' => false,
        ]);
        $this->emitTo('order.settle-modal','abrirModal',$settlement,$order);
    }

    public function blending(){
        if($this->settlementId != []){
            $this->emitTo('settlement.blending-modal','abrirModal',$this->settlementId);
        }else{
            $this->alert('warning', '¡No ha seleccionado ninguna liquidación!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {
        $this->boton_activo = $this->settlementId != [];
        $settlements = $this->getSettlements();

        return view('livewire.settlement.base',compact('settlements'));
    }
}
