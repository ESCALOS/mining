<?php

namespace App\Http\Livewire\Sent;

use App\Models\Dispatch;
use Livewire\Component;
use Livewire\WithPagination;

class Base extends Component
{
    use WithPagination;

    public $dispatchId;
    public $search;

    public function mount(){
        $this->dispatchId = 0;
        $this->search = "";
    }

    public function getDispatches(){
        $dispatches = Dispatch::when($this->search != "", function($q){
            return $q->where('batch','like','%'.$this->search.'%');
        })->withSum('details','wmt')->where('shipped',1)->latest()->paginate(6);
        return $dispatches;
    }

    public function render()
    {
        $dispatches = $this->getDispatches();
        return view('livewire.sent.base',compact('dispatches'));
    }
}
