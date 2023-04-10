<?php

namespace App\Http\Livewire\Order;

use App\Models\Concentrate;
use App\Models\Entity;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class Modal extends Component
{
    use LivewireAlert;

    public $open;
    public $orderId;
    public $ticket;
    public $clientDocumentNumber;
    public $clientName;
    public $clientAddress;
    public $concentrateId;
    public $concentrates;
    public $wmt;
    public $origin;
    public $carriageDocumentNumber;
    public $carriageName;
    public $plateNumber;
    public $transportGuide;
    public $deliveryNote;
    public $weighingScaleDocumentNumber;
    public $weighingScaleName;
    public $settled;

    protected $listeners = ['abrirModal'];

    protected function rules(){
        return [
            'ticket' => 'required|unique:orders,ticket,'.$this->orderId,
            'clientDocumentNumber' => 'required',
            'clientName' => 'required',
            'clientAddress' => 'required',
            'concentrateId' => 'required|exists:concentrates,id',
            'wmt' => 'required|decimal:0,3',
            'origin' => 'required',
            'carriageDocumentNumber' => 'required',
            'carriageName' => 'required',
            'plateNumber' => 'required|size:7',
            'transportGuide' => 'required|unique:orders,transport_guide,'.$this->orderId,
            'deliveryNote' => 'required|unique:orders,delivery_note,'.$this->orderId,
            'weighingScaleDocumentNumber' => 'required',
            'weighingScaleName' => 'required'
        ];
    }

    public function messages(){
        return [
            'ticket.required' => "El ticket es requerido",
            'ticket.unique' => "El ticket ya existe",
            'clientDocumentNumber.required' => "El número del documento del cliente es requerido",
            'clientName.required' => "El nombre del cliente es requerido",
            'clientAddress.required' => "El dirección del cliente es requerido",
            'concentrateId.required' => "El concentrado es requerido",
            'wmt.required' => "La TMH es requerida",
            'origin.required' => "La procedencia es requerida",
            'carriageDocumentNumber.required' => 'El ruc del transportista es requerido',
            'carriageName.required' => 'La razón social del transportuista es requerida',
            'plateNumber.required' => 'La placa es requerida',
            'plateNumber.size' => 'Placa incorrecta',
            'transportGuide.required' => 'La guía de transporte es requerida',
            'transportGuide.unique' => 'La guía de transporte debe ser única',
            'deliveryNote.required' => 'La guía de remisión es requerida',
            'deliveryNote.unique' => 'La guía de remisión debe ser única',
            'weighingScaleDocumentNumber.required' => 'El ruc de balanza es requerido',
            'weighingScaleName.required' => 'La razón social de la balanza es requerida',
        ];
    }

    public function mount(){
        $this->open =false;
        $this->orderId = 0;
        $this->ticket = "";
        $this->clientDocumentNumber = "";
        $this->clientName = "";
        $this->clientAddress = "";
        $this->concentrateId = 0;
        $this->concentrates = Concentrate::all();
        $this->wmt = "";
        $this->origin = "";
        $this->carriageDocumentNumber = "";
        $this->carriageName = "";
        $this->plateNumber = "";
        $this->transportGuide = "";
        $this->deliveryNote = "";
        $this->weighingScaleDocumentNumber = "";
        $this->weighingScaleName = "";
        $this->settled = true;
    }

    public function abrirModal($id){
        $this->resetValidation();
        $this->resetExcept('open','concentrates');
        $this->orderId = $id;
        if($id > 0){
            $order = Order::find($id);
            $this->ticket = $order->ticket;
            $this->clientDocumentNumber = $order->Client->document_number;
            $this->clientName = $order->Client->name;
            $this->clientAddress = $order->Client->address;
            $this->concentrateId = $order->concentrate_id;
            $this->wmt = number_format($order->wmt,3);
            $this->origin = $order->origin;
            $this->carriageDocumentNumber = $order->Carriage->document_number;
            $this->carriageName = $order->Carriage->name;
            $this->plateNumber = $order->plate_number;
            $this->transportGuide = $order->transport_guide;
            $this->deliveryNote = $order->delivery_note;
            $this->weighingScaleDocumentNumber = $order->WeighingScale->document_number;
            $this->weighingScaleName = $order->WeighingScale->name;
            $this->settled = $order->settled;
        }
        $this->open = true;
    }
    //Buscar Cliente
    public function updatedClientDocumentNumber (){
        $tipoDocumento = $this->checkDocumentNumber($this->clientDocumentNumber);
        if($tipoDocumento == ""){
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
               ]);
            $this->reset('clientName','clientAddress');
            return false;
        }
        if(Entity::where('document_number',$this->clientDocumentNumber)->exists()){
            $empresa = Entity::where('document_number',$this->clientDocumentNumber)->first();
            $this->clientName = $empresa->name;
            $this->clientAddress = $empresa->address;
            $this->alert('success', 'Cliente Encontrado', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $empresa = $this->getEntityApi($this->clientDocumentNumber,$tipoDocumento);
            if(isset($empresa->numeroDocumento)){
                $this->clientName = $empresa->nombre;
                $this->clientAddress = $empresa->direccion;
                $this->alert('success', 'Cliente Encontrado', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }else{
                $this->reset('clientName','clientAddress');
                $this->alert('error', 'El Cliente no existe', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }
        }
    }
    //Buscar Transportista
    public function updatedCarriageDocumentNumber(){
        $tipoDocumento = $this->checkDocumentNumber($this->carriageDocumentNumber);
        if($tipoDocumento == ""){
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
               ]);
            $this->reset('carriageName');
            return false;
        }
        if(Entity::where('document_number',$this->carriageDocumentNumber)->exists()){
            $empresa = Entity::where('document_number',$this->carriageDocumentNumber)->first();
            $this->carriageName = $empresa->name;
            $this->alert('success', 'Transportista Encontrado', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $empresa = $this->getEntityApi($this->carriageDocumentNumber,$tipoDocumento);
            if(isset($empresa->numeroDocumento)){
                $this->carriageName = $empresa->nombre;
                $this->alert('success', 'Transportista Encontrado', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }else{
                $this->reset('carriageName');
                $this->alert('error', 'El Transportista no existe', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }
        }
    }
    //Buscar Balanza
    public function updatedweighingScaleDocumentNumber(){
        $tipoDocumento = $this->checkDocumentNumber($this->weighingScaleDocumentNumber);
        if($tipoDocumento == ""){
            $this->alert('warning', 'Ruc o Dni incorrecto', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
               ]);
            $this->reset('weighingScaleName');
            return false;
        }
        if(Entity::where('document_number',$this->weighingScaleDocumentNumber)->exists()){
            $empresa = Entity::where('document_number',$this->weighingScaleDocumentNumber)->first();
            $this->weighingScaleName = $empresa->name;
            $this->alert('success', 'Transportista Encontrado', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $empresa = $this->getEntityApi($this->weighingScaleDocumentNumber,$tipoDocumento);
            if(isset($empresa->numeroDocumento)){
                $this->weighingScaleName = $empresa->nombre;
                $this->alert('success', 'Transportista Encontrado', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }else{
                $this->reset('weighingScaleName');
                $this->alert('error', 'El Transportista no existe', [
                    'position' => 'top-right',
                    'timer' => 2000,
                    'toast' => true,
                ]);
            }
        }
    }

    public function registrar(){
        $this->validate();
        $entity = Entity::where('document_number',$this->clientDocumentNumber)->first();
        $entity->address = strtoupper($this->clientAddress);
        $entity->save();
        if($this->orderId > 0){
            $order = Order::find($this->orderId);
        }else{
            $order = new Order();
        }
        $order->ticket = strtoupper($this->ticket);
        $order->batch = "2304-0001";
        $order->client_id = Entity::where('document_number',$this->clientDocumentNumber)->first()->id;
        $order->concentrate_id = $this->concentrateId;
        $order->wmt = $this->wmt;
        $order->origin = strtoupper($this->origin);
        $order->carriage_company_id = Entity::where('document_number',$this->carriageDocumentNumber)->first()->id;
        $order->plate_number = strtoupper($this->plateNumber);
        $order->transport_guide = strtoupper($this->transportGuide);
        $order->delivery_note = strtoupper($this->deliveryNote);
        $order->weighing_scale_company_id = Entity::where('document_number',$this->weighingScaleDocumentNumber)->first()->id;
        $order->user_id = Auth::user()->id;
        $order->save();
        $this->alert('success', '¡Concentrado guardado!', [
            'position' => 'top-right',
            'timer' => 2000,
            'toast' => true,
           ]);
        $this->emitTo('order.base', 'render');
        if($this->orderId > 0){
            $this->open = false;
        }
        $this->resetExcept('open','concentrates');
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
        return view('livewire.order.modal');
    }
}
