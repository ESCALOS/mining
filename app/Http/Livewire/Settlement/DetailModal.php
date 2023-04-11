<?php

namespace App\Http\Livewire\Settlement;

use App\Models\Settlement;
use Livewire\Component;

class DetailModal extends Component
{
    public $open;
    public $settlementId;
    public $payableTotal;
    public $deductionTotal;
    public $penaltyTotal;
    public $total_unit;
    public $batch_value;
    public $igv;
    public $detraccion;
    public $total;

    protected $listeners = ['showDetails'];

    public function mount(){
        $this->open = false;
        $this->payableTotal = 0;
        $this->deductionTotal = 0;
        $this->penaltyTotal = 0;
        $this->total_unit = 0;
        $this->batch_value = 0;
        $this->igv = 0;
        $this->detraccion = 0;
        $this->total = 0;
    }

    public function showDetails($id){
        $this->settlementId = $id;
        $this->open = true;
    }

    public function render()
    {
        if($this->settlementId > 0){
            $settlement = Settlement::find($this->settlementId);
            $this->payableTotal = $settlement->PayableTotal->total_price_copper+$settlement->PayableTotal->total_price_silver+$settlement->PayableTotal->total_price_gold;
            $this->deductionTotal = $settlement->DeductionTotal->total_price_copper+$settlement->DeductionTotal->total_price_silver+$settlement->DeductionTotal->total_price_gold+$settlement->DeductionTotal->maquila+$settlement->DeductionTotal->analysis+$settlement->DeductionTotal->stevedore;
            $this->penaltyTotal = $settlement->PenaltyTotal->total_arsenic+$settlement->PenaltyTotal->total_antomony+$settlement->PenaltyTotal->total_bismuth+$settlement->PenaltyTotal->total_lead+$settlement->PenaltyTotal->total_zinc+$settlement->PenaltyTotal->total_mercury;
            $this->total_unit = $this->payableTotal - $this->deductionTotal - $this->penaltyTotal;
            $this->batch_value = $this->total_unit*$settlement->Law->tmns;
            $this->igv = $this->batch_value*0.18;
            $this->detraccion = ($this->batch_value+$this->igv)*0.1;
            $this->total = $this->batch_value + $this->igv - $this->detraccion;
        }else{
            $settlement = [];
            $this->payableTotal = 0;
            $this->deductionTotal = 0;
            $this->penaltyTotal = 0;
            $this->total_unit = 0;
            $this->batch_value = 0;
            $this->igv = 0;
            $this->detraccion = 0;
            $this->total = 0;
        }

        return view('livewire.settlement.detail-modal',compact('settlement'));
    }
}
