<?php

namespace App\Http\Livewire\Dispatch;

use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\Settlement;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Base extends Component
{
    use WithPagination;
    use LivewireAlert;

    public $dispatchId;
    public $search;

    protected $listeners = ['confirmShip','ship','pullApart'];

    public function mount(){
        $this->dispatchId = 0;
        $this->search = "";
    }

    public function confirmShip($id){
        $this->dispatchId = $id;
        $this->alert('question','¿Estas seguro de enviar?',[
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
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

    public function confirmPullApart($id){
        $this->dispatchId = $id;
        $this->alert('question','¿Estas seguro de deshacer la mezcla?',[
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'position' => 'center',
            'toast' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'timer' => 10000,
            'onConfirmed' => 'pullApart',
        ]);
    }

    public function pullApart(){
        try{
            DB::transaction(function(){
                DispatchDetail::where('dispatch_id',$this->dispatchId)->delete();
                Dispatch::find($this->dispatchId)->delete();
                $this->alert('success', '¡Blending deshecho!', [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            });
        }catch(\Exception $e){
            $this->alert('error', $e, [
                'position' => 'center',
                'timer' => 5000,
                'toast' => false,
            ]);
        }
        $this->dispatchId = 0;
    }

    public function getDispatches(){
        $dispatches = Dispatch::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->withSum('details','wmt')->where('shipped',0)->latest()->paginate(10);
        return $dispatches;
    }

    public function render()
    {
        $dispatches = $this->getDispatches();

        return view('livewire.dispatch.base',compact('dispatches'));
    }
}
