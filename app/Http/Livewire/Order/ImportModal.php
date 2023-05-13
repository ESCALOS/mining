<?php

namespace App\Http\Livewire\Order;

use App\Exceptions\ImportErrorException;
use App\Exports\OrdersExport;
use App\Imports\OrdersImport;
use Illuminate\Support\Facades\Response;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
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
        $this->file_number++;
        $this->archivo = null;
        $this->open = true;
    }

    public function exportarFormato(){
        $columnas = ['TICKET', 'RUC_CLIENTE', 'DIRECCION','CONCENTRADO','SIMBOLO','TMH','PROCEDENCIA','RUC_TRANSPORTISTA','NUMERO_DE_PLACA','GUIA_DE_TRANSPORTE','GUIA_DE_REMISION','RUC_BALANZA'];
        $export = new OrdersExport($columnas);
        $fileName = 'Formato de Ordenes.xlsx';

        return Response::streamDownload(function () use ($export) {
            Excel::store($export, 'temp.xlsx');
            readfile(storage_path('app/temp.xlsx'));
        }, $fileName);
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
        } catch (ImportErrorException $e) {
            $this->alert('error', $e->getMessage(), [
                'position' => 'center',
                'timer' => 10000,
                'toast' => false,
            ]);
        } catch (\Exception $e) {
            $this->alert('error','Revise sus datos', [
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
