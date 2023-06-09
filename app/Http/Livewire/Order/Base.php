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
    public $estado;

    protected $listeners = ['render','anuladoConfirmado','confirmSettle'];

    public function mount(){
        $this->search = "";
        $this->orderId = 0;
        $this->boton_activo = false;
        $this->estado = "";
    }

    public function seleccionar($id) {
        $this->orderId = $id;
    }

    public function eliminar(){
        if(Order::find($this->orderId)->settled){
            $this->alert('warning', '¡No se puede eliminar la orden!', [
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
        $this->alert('success', '¡Orden Eliminada!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
        ]);
        $this->render();
    }

    public function getOrders(){
        $orders = Order::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%')->orWhereHas('Client',function($q){
                return $q->where('name','like','%'.$this->search.'%');
            })->orWhereHas('Concentrate',function($q){
                return $q->where('concentrate','like','%'.$this->search.'%');
            });
        });
        if($this->estado == 1 || $this->estado == 0){
            $orders = $orders->where('settled',$this->estado);
        }
        $orders = $orders->orderBy('batch','desc')->paginate(10);
        return $orders;
    }

    public function render()
    {
        $this->boton_activo = $this->orderId > 0;
        $orders = $this->getOrders();

        return view('livewire.order.base',compact('orders'));
    }
}
