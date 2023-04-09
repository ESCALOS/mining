<?php

namespace App\Http\Livewire\Concentrate;

use App\Models\Concentrate;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $concentrateId;
    public $concentrate;
    public $chemical_symbol;

    protected $listeners = ['abrirModal'];

    protected function rules(){
        return [
            'concentrate' => 'required|unique:concentrates,concentrate,'.$this->concentrateId,
            'chemical_symbol' => 'required|unique:concentrates,chemical_symbol,'.$this->concentrateId,
        ];
    }

    public function mount(){
        $this->open =false;
        $this->concentrateId = 0;
        $this->concentrate = "";
        $this->chemical_symbol = "";
    }

    public function abrirModal($id){
        $this->resetValidation();
        $this->concentrateId = $id;
        if($id > 0){
            $concentrate = Concentrate::find($id);
            $this->concentrate = $concentrate->concentrate;
            $this->chemical_symbol = $concentrate->chemical_symbol;
        }else{
            $this->reset('concentrate','chemical_symbol');
        }
        $this->open = true;
    }

    public function registrar(){
        $this->validate();
        if($this->concentrateId > 0){
            $concentrate = Concentrate::find($this->concentrateId);

        }else{
            $concentrate = new Concentrate();
        }
        $concentrate->concentrate = strtoupper($this->concentrate);
        $concentrate->chemical_symbol = strtoupper($this->chemical_symbol);
        $concentrate->save();
        $this->alert('success', '¡Concentrado guardado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
           ]);
        $this->emitTo('concentrate.base', 'render');
        $this->open = false;
    }

    public function render()
    {
        return view('livewire.concentrate.modal');
    }
}
