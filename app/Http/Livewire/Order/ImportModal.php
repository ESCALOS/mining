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
        $this->alert('info', 'Opción deshabilitada',[
            'position' => 'center',
            'timer' => 1500,
            'toast' => false,
        ]);
        /*$this->file_number++;
        $this->archivo = null;
        $this->open = true;*/
    }

    public function importar(){
        $this->validate();
        $archivo = Excel::toArray([], $this->archivo);

        // Accede a la hoja que quieres validar
        $hoja = $archivo[0];

        // Verifica si todas las celdas que necesitas existen en la hoja
        $celdas = ['lote_orden', 'ticket', 'ruc_cliente','DIRECCION','CONCENTRADO','SIMBOLO','TMH','PROCEDENCIA','RUC_TRANSPORTISTA','NUMERO_DE_PLACA','GUIA_DE_TRANSPORTE','GUIA_DE_REMISION','RUC_BALANZA','LOTE_LIQUIDACION','COBRE_INTERNACIONAL','PLATA_INTERNACIONAL','ORO_INTERNACIONAL','LEY_PLATA','FACTOR_PLATA','LEY_ORO','FACTOR_ORO','PAGABLE_COBRE','PAGABLE_PLATA','PAGABLE_ORO','PROTECCION_COBRE','PROTECCION_PLATA','PROTECION_ORO','DEDUCCION_COBRE','DEDUCCION_PLATA','DEDUCCION_ORO','REFINAMIENTO_COBRE','REFINAMIENTO_PLATA','REFINAMIENTO_ORO','MAQUILA','ANALISIS','ESTIBADORES','PENALIDAD_ARSENICO','PENALIDAD_ANTIMONIO','PENALIDAD_PLOMO','PENALIDAD_ZINC','PENALIDAD_BISMUTO','PENALIDAD_MERCURIO','MAXIMO_ARSENICO','MAXIMO_ANTIMONIO','MAXIMO_PLOMO','MAXIMO_ZINC','MAXIMO_BISMUTO','MAXIMO_MERCURIO'];
        $celdas_faltantes = [];
        foreach ($celdas as $celda) {
            if (!isset($hoja[$celda])) {
                array_push($celdas_faltantes, $celda);
            }
        }
        if(!empty($celdas_faltantes)){
            $celdas_string = "";
            foreach ($celdas_faltantes as $celdas_faltante){
                $celdas_string = $celdas_string.", ".$celdas_faltante;
            }
            $this->alert('error', "Falta la columna ".$celdas_string, [
                'position' => 'center',
                'timer' => null,
                'toast' => false,
            ]);
            return false;
        }else{
            $this->alert('error', "Están todas als columnas", [
                'position' => 'center',
                'timer' => null,
                'toast' => false,
            ]);
        }
        /*try {
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
        }*/
    }

    public function render()
    {
        return view('livewire.order.import-modal');
    }
}
