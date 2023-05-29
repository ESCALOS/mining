<?php

namespace App\Http\Livewire\Dispatch;

use App\Models\Dispatch;
use App\Models\DispatchDetail;
use App\Models\Entity;
use App\Models\Profitability;
use App\Models\ProfitabilityLaw;
use App\Models\ProfitabilityPenalty;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DetailModal extends Component
{
    use LivewireAlert;

    public $open;
    public $dispatchId;
    public $shipped;
    public $wmt_total;
    public $amount_total;
    public $dnwmt_total;
    public $copper_total;
    public $silver_total;
    public $gold_total;
    public $arsenic_total;
    public $antomony_total;
    public $lead_total;
    public $zinc_total;
    public $bismuth_total;
    public $mercury_total;
    //Rentabilidad
    public $rentTipoDoc;
    public $rentSerie;
    public $rentNumero;
    public $rentRuc;
    public $rentCliente;
    public $rentImponible;
    //Rentabilidad Ley
    public $rentCopper;
    public $rentSilver;
    public $rentGold;
    //Rentabilidad Penalidad
    public $rentArsenic;
    public $rentAntomony;
    public $rentLead;
    public $rentZinc;
    public $rentBismuth;
    public $rentMercury;

    protected $listeners = ['abrirModal','cerrarModal'];

    protected function rules(){
        return [
            'rentSerie' => 'required',
            'rentNumero' => 'required',
            'rentRuc' => 'required',
            'rentCliente' => 'required',
            'rentImponible' => 'required',
        ];
    }

    public function messages(){
        return [
            'rentSerie.required' => "La serie es requerida",
            'rentNumero.required' => "El numero es requerido",
            'rentRuc.required' => "El número del documento del cliente es requerido",
            'rentCliente.required' => "El nombre del cliente es requerido",
            'rentImponible.required' => "La base imponible es requerida",
        ];
    }

    public function mount(){
        $this->open = false;
        $this->dispatchId = 0;
        $this->shipped = true;
        $this->wmt_total = 0;
        $this->amount_total = 0;
        $this->dnwmt_total = 0;
        $this->copper_total = 0;
        $this->silver_total = 0;
        $this->gold_total = 0;
        $this->arsenic_total = 0;
        $this->antomony_total = 0;
        $this->lead_total = 0;
        $this->zinc_total = 0;
        $this->bismuth_total = 0;
        $this->mercury_total = 0;
        //Rentabilidad
        $this->rentTipoDoc = "Factura";
        $this->rentSerie = "";
        $this->rentNumero = "";
        $this->rentRuc = "";
        $this->rentCliente = "";
        $this->rentImponible = "";
        //Rentabilidad Ley
        $this->rentCopper = 0;
        $this->rentSilver = 0;
        $this->rentGold = 0;
        //Rentabilidad Penalidad
        $this->rentArsenic = 0;
        $this->rentAntomony = 0;
        $this->rentLead = 0;
        $this->rentZinc = 0;
        $this->rentBismuth = 0;
        $this->rentMercury = 0;
    }

    //Buscar Cliente
    public function updatedRentRuc (){
        $tipoDocumento = $this->checkDocumentNumber($this->rentRuc);
        if($tipoDocumento == ""){
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
               ]);
            $this->reset('rentCliente');
            return false;
        }
        if(Entity::where('document_number',$this->rentRuc)->exists()){
            $empresa = Entity::where('document_number',$this->rentRuc)->first();
            $this->rentCliente = $empresa->name;
            $this->alert('success', 'Cliente Encontrado', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $empresa = $this->getEntityApi($this->rentRuc,$tipoDocumento);
            if(isset($empresa->numeroDocumento)){
                $this->rentCliente = $empresa->nombre;
                $this->alert('success', 'Cliente Encontrado', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }else{
                $this->reset('rentCliente');
                $this->alert('error', 'El Cliente no existe', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }
        }
    }

    public function abrirModal($id){
        $this->dispatchId = $id;
        $this->shipped = Dispatch::find($id)->shipped;

        if(Profitability::where('dispatch_id',$this->dispatchId)->exists()){
            $profitability = Profitability::where('dispatch_id',$this->dispatchId)->first();
            $profitabilityLaw = ProfitabilityLaw::where('dispatch_id',$this->dispatchId)->first();
            $profitabilityPenalty = ProfitabilityPenalty::where('dispatch_id',$this->dispatchId)->first();
            $this->rentTipoDoc = $profitability->tipDoc;
            $this->rentSerie = $profitability->serie;
            $this->rentNumero = $profitability->number;
            $this->rentRuc = $profitability->Client->document_number;
            $this->rentCliente = $profitability->Client->name;
            $this->rentImponible = $profitability->imponible;
            //Rentabilidad Ley
            $this->rentCopper = number_format($profitabilityLaw->copper,3);
            $this->rentSilver = number_format($profitabilityLaw->silver,3);
            $this->rentGold = number_format($profitabilityLaw->gold,3);
            //Rentabilidad Penalidad
            $this->rentArsenic = number_format($profitabilityPenalty->arsenic,3);
            $this->rentAntomony = number_format($profitabilityPenalty->antomony,3);
            $this->rentLead = number_format($profitabilityPenalty->lead,3);
            $this->rentZinc = number_format($profitabilityPenalty->zinc,3);
            $this->rentBismuth = number_format($profitabilityPenalty->bismuth,3);
            $this->rentMercury = number_format($profitabilityPenalty->mercury,3);
        }else{
            //Rentabilidad
            $this->rentTipoDoc = "Factura";
            $this->rentSerie = "";
            $this->rentNumero = "";
            $this->rentRuc = "";
            $this->rentCliente = "";
            $this->rentImponible = "";
            //Rentabilidad Ley
            $this->rentCopper = 0;
            $this->rentSilver = 0;
            $this->rentGold = 0;
            //Rentabilidad Penalidad
            $this->rentArsenic = 0;
            $this->rentAntomony = 0;
            $this->rentLead = 0;
            $this->rentZinc = 0;
            $this->rentBismuth = 0;
            $this->rentMercury = 0;
        }

        $this->open = true;
    }

    public function cerrarModal(){
        $this->open = false;
    }

    public function printDispatch(){

        $dispatchDetails = DispatchDetail::where('dispatch_id',$this->dispatchId)->get();
        $dispatch = Dispatch::find($this->dispatchId);
        $data = [
            'dispatchDetails' => $dispatchDetails,
            'batch' => $dispatch->batch,
            'shipped' => $dispatch->shipped,
        ];
        $titulo = "Despacho ".$dispatch->batch.'.pdf';
        $pdfContent = PDF::loadView('livewire.dispatch.pdf.dispatch', $data)->setPaper('a4','portrait')->output();

        return response()->streamDownload(
            fn () => print($pdfContent),
            $titulo
        );
    }

    public function saveProfitability(){
        $this->validate();
        if(Profitability::where('dispatch_id',$this->dispatchId)->exists()){
            $profitability = Profitability::where('dispatch_id',$this->dispatchId)->first();
            $profitabilityLaw = ProfitabilityLaw::where('dispatch_id',$this->dispatchId)->first();
            $profitabilityPenalty = ProfitabilityPenalty::where('dispatch_id',$this->dispatchId)->first();
        }else{
            $profitability = new Profitability();
            $profitability->dispatch_id = $this->dispatchId;
            $profitabilityLaw = new ProfitabilityLaw();
            $profitabilityLaw->dispatch_id = $this->dispatchId;
            $profitabilityPenalty = new ProfitabilityPenalty();
            $profitabilityPenalty->dispatch_id = $this->dispatchId;
        }

        $profitability->tipoDoc = $this->rentTipoDoc;
        $profitability->serie = $this->rentSerie;
        $profitability->number = $this->rentNumero;
        $profitability->client_id = Entity::where('document_number',$this->rentRuc)->first()->id;
        $profitability->imponible = $this->rentImponible;

        $profitabilityLaw->copper = $this->rentCopper;
        $profitabilityLaw->silver = $this->rentSilver;
        $profitabilityLaw->gold = $this->rentGold;

        $profitabilityPenalty->arsenic = $this->rentArsenic;
        $profitabilityPenalty->antomony = $this->rentAntomony;
        $profitabilityPenalty->lead = $this->rentLead;
        $profitabilityPenalty->zinc = $this->rentZinc;
        $profitabilityPenalty->bismuth = $this->rentBismuth;
        $profitabilityPenalty->mercury = $this->rentMercury;

        $profitability->save();
        $profitabilityLaw->save();
        $profitabilityPenalty->save();

        $this->alert('success', 'Rentabilidad Guardada', [
            'position' => 'center',
            'timer' => 2000,
            'toast' => false,
        ]);

    }

    public function checkDocumentNumber($numero){
        $tipoDocumento = strlen($numero);
        switch ($tipoDocumento) {
            case 8:
                $tipoDocumento = "dni";
                break;
            case 11:
                $tipoDocumento = "ruc";
                break;
            default:
                $tipoDocumento = "";
                break;
        }
        return $tipoDocumento;
    }

    public function getEntityApi($numero,$tipoDocumento){
                // Iniciar llamada a API
            $curl = curl_init();

            // Buscar ruc sunat
            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.apis.net.pe/v1/'.$tipoDocumento.'?numero=' . $numero,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            CURLOPT_HTTPHEADER => array(
                'Referer: http://apis.net.pe/api-ruc',
                'Authorization: Bearer ' . env('API_SUNAT')
            ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            $empresa = json_decode($response);
            if(isset($empresa->numeroDocumento)){
                Entity::updateOrCreate([
                    'document_number' => $empresa->numeroDocumento,
                    'name' => strtoupper($empresa->nombre),
                    'address' => strtoupper($empresa->direccion)
                ]);
            }

            // Datos de empresas según padron reducido
            return $empresa;
    }

    public function render()
    {
        $dispatchDetails = DispatchDetail::where('dispatch_id',$this->dispatchId)->get();

        return view('livewire.dispatch.detail-modal',compact('dispatchDetails'));
    }
}
