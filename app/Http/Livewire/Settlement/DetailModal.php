<?php

namespace App\Http\Livewire\Settlement;

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
