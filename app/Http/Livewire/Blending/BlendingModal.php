<?php

namespace App\Http\Livewire\Blending;

use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\Settlement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class BlendingModal extends Component
{
    use LivewireAlert;

    public $open;
    public $settlementId;
    public $date;
    public $batch;
    public $concentrate;
    public $wmt;
    public $missingWmt;
    public $wmtToShip;
    public $maximumWmt;

    protected $listeners = ['abrirModal','blending'];

    public function mount(){
        $this->open = false;
        $this->date = Carbon::now()->toDateString();
        $this->settlementId = [];
        $this->maximumWmt = 0;
        $this->batch = [];
        $this->concentrate = [];
        $this->wmt = [];
        $this->missingWmt = [];
        $this->wmtToShip = [];
    }

    public function abrirModal($settlementId){
        $this->settlementId = $settlementId;
        $this->date = Carbon::now()->toDateString();
        $this->maximumWmt = 0;
        $this->batch = [];
        $this->concentrate = [];
        $this->wmt = [];
        $this->missingWmt = [];
        $this->wmtToShip = [];
        foreach($this->settlementId as $key => $id){
            $settlement = Settlement::find($id);
            $this->batch[$key] = $settlement->batch;
            $this->concentrate[$key] = $settlement->Order->Concentrate->concentrate;
            $this->wmt[$key] = $settlement->Order->wmt;
            $this->missingWmt[$key] = $this->wmt[$key] - $settlement->wmt_shipped;
            $this->wmtToShip[$key] = $this->missingWmt[$key];
        }
        $this->open = true;
    }

    public function confirmBlending(){
        if($this->maximumWmt == 0){
            $this->alert('error', '¡Ingrese la cantidad a mezclar!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
               ]);
            return false;
        }

        foreach($this->settlementId as $key => $id){
            if($this->wmtToShip[$key] <= 0){
                $this->alert('error', '¡La cantidad a enviar no puede ser 0 en el lote '.$this->batch[$key].'!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                   ]);
                return false;
            }
        }

        foreach($this->settlementId as $key => $id){
            if($this->wmtToShip[$key] > $this->missingWmt[$key] ){
                $this->alert('error', '¡La cantidad a enviar es mayor a la sobrante en el lote '.$this->batch[$key].'!', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => false,
                   ]);
                return false;
            }
        }

        if(array_sum($this->wmtToShip) > $this->maximumWmt) {
            $this->alert('error', '¡La cantidad a mezclar excede a la declarada!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
               ]);
            return false;
        }
        $this->alert('question','¿Estas seguro de mezclar?',[
            'showConfirmButton' => true,
            'confirmButtonText' => 'Sí',
            'position' => 'center',
            'toast' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'No',
            'timer' => 10000,
            'onConfirmed' => 'blending',
        ]);
    }

    public function blending(){
        try{
            DB::transaction(function(){
                $dispatch = Dispatch::create([
                    'batch' => $this->createBatch(),
                    'user_id' => Auth::user()->id,
                    'date_blending' => $this->date,
                    'date_shipped' => null
                ]);
                foreach($this->settlementId as $key => $id){
                    DispatchDetail::create([
                        'dispatch_id' => $dispatch->id,
                        'settlement_id' => $id,
                        'wmt' => $this->wmtToShip[$key]
                    ]);
                    $settlement = Settlement::find($id);
                    $settlement->wmt_shipped = $settlement->wmt_shipped + $this->wmtToShip[$key];
                    $settlement->save();
                }
                $this->alert('success', '¡Blending Exitoso!', [
                    'position' => 'center',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            });
            $this->emitTo('blending.base','render');
            $this->open = false;
        }catch(\Exception $e){
            $this->alert('error', $e, [
                'position' => 'center',
                'timer' => 5000,
                'toast' => false,
                ]);
        }
    }

    public function createBatch(){
        $fecha = 'D'.Carbon::now()->isoFormat('YYMM');
        $correlativo = '0001';
        if(Dispatch::limit(1)->exists()){
            $last_batch = explode("-",Dispatch::orderBy('batch','desc')->first()->batch);
            if($fecha == $last_batch[0]){
                $correlativo = str_pad(strval(intval($last_batch[1])+1),4,0,STR_PAD_LEFT);
            }
        }

        return $fecha.'-'.$correlativo;
    }
    public function render()
    {
        return view('livewire.blending.blending-modal');
    }
}
