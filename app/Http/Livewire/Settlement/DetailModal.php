<?php

namespace App\Http\Livewire\Settlement;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Settlement;
use Livewire\Component;

class DetailModal extends Component
{
    public $open;
    public $settlementId;

    protected $listeners = ['showDetails'];

    public function mount(){
        $this->open = false;
    }

    public function showDetails($id){
        $this->settlementId = $id;
        $this->open = true;
    }

    public function printSettlement(){

        $settlement = Settlement::find($this->settlementId);

        $data = [
            'settlement' => $settlement
        ];
        $titulo = "Liquidación ".$settlement->batch.'.pdf';
        $pdfContent = PDF::loadView('livewire.settlement.pdf.settlement', $data)->setPaper('a4','portrait')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            $titulo
        );
    }

    public function render()
    {
        if($this->settlementId > 0){
            $settlement = Settlement::find($this->settlementId);
        }else{
            $settlement = [];
        }
        return view('livewire.settlement.detail-modal',compact('settlement'));
    }
}
