<?php

namespace App\Http\Livewire\Order;

use App\Models\Order;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $orderId;
    public $search;
    public $boton_activo;

    protected $listeners = ['render'];

    public function mount(){
        $this->search = "";
        $this->orderId = 0;
        $this->boton_activo = false;
    }

    public function seleccionar($id) {
        $this->orderId = $id;
    }

    public function anular(){
        if(Order::has('orders')->where('id',$this->orderId)->exists()){
            $this->alert('warning', '¡No se puede eliminar el concentrado!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->alert('question','¿Estas seguro de eliminar?',[
                'showConfirmButton' => true,
                'confirmButtonText' => 'Sí',
                'onConfirmed' => 'confirmed',
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
        Order::find($this->orderId)->delete();
        $this->orderId = 0;
        $this->alert('success', '¡Concentrado Eliminado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
        ]);
        $this->render();
    }

    public function getOrders(){
        $orders = Order::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->paginate(6);
        return $orders;
    }

    public function render()
    {
        $this->boton_activo = $this->orderId > 0;
        $empresa = null;
        $orders = $this->getOrders();
        /*$tipoDocumento = $this->checkDocumentNumber('70821326');
        if($tipoDocumento == "ruc" || $tipoDocumento == "dni"){
            $empresa = $this->getEntity('70821326',$tipoDocumento);
            $this->alert('success', '¡Encontrado!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->alert('warning', '¡No se puede eliminar el concentrado!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }*/

        return view('livewire.order.base',compact('orders','empresa'));
    }
}
