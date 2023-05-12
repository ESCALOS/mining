<?php

namespace App\Http\Livewire\Order;

use App\Imports\OrdersImport;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Validators\ValidationException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ImportModal extends Component
{
    use WithFileUploads;
    use LivewireAlert;

    public $open;
    public $archivo;
    public $file_number;

    protected $listeners = ['abrirModal'];

    public function mount()
    {
        $this->open = false;
    }

    public function rules(){
        return [
            'archivo' => 'required|file'
        ];
    }

    public function abrirModal(){
        /*$this->alert('info', 'Opción deshabilitada',[
            'position' => 'center',
            'timer' => 1500,
            'toast' => false,
        ]);*/
        $this->file_number++;
        $this->archivo = null;
        $this->open = true;
    }

    public function importar(){
        $this->validate();

        try {
            Excel::import(new OrdersImport, $this->archivo);
            $this->alert('success', '¡Importación exitosa!', [
                'position' => 'center',
                'timer' => 2000,
                'toast' => false,
            ]);
            $this->emitTo('order.base', 'render');
            $this->open = false;
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $errores = $e->failures();
            $this->alert('error', $errores[0]->errors(), [
                'position' => 'center',
                'timer' => 10000,
                'toast' => false,
            ]);
        }
    }

    public function render()
    {
        return view('livewire.order.import-modal');
    }
}
