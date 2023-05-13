<?php

namespace App\Imports;

use App\Exceptions\ImportErrorException;
use App\Models\Concentrate;
use App\Models\Entity;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class OrdersImport implements OnEachRow,WithHeadingRow
{

    private $latestBatchNumber;
    private $hasError = false;
    private $errorMessage;
    private $i;


    public function __construct()
    {
        // Obtener el número de lote más alto actual
        $latestBatch = DB::table('orders')->orderBy('batch', 'desc')->first();
        $this->latestBatchNumber = $latestBatch ? substr($latestBatch->batch, -4) : 0;
        $this->i = 1;
    }

    public function onRow(Row $row)
    {

        $tipoDocumento = $this->checkDocumentNumber($row['ruc_cliente']);
        if($row['ticket'] != "" && $row['ticket'] != null && $tipoDocumento != "") {

            $this->latestBatchNumber++;
            $this->i++;

            $concentrate = Concentrate::firstOrCreate([
                'concentrate' => $row['concentrado'],
                'chemical_symbol' => $row['simbolo']
            ]);

            $year = date('y');
            $month = date('m');
            $correlative = str_pad($this->latestBatchNumber, 4, '0', STR_PAD_LEFT);

            $cliente = $this->getEntity($row['ruc_cliente'],$tipoDocumento,empty($row['direccion']) ? '' : $row['direccion']);

            if($cliente == null){
                throw new ImportErrorException("El ruc del cliente ".$row['ruc_cliente']." es inválido en la fila ".$this->i);
            }

            $transportista = $this->getEntity($row['ruc_transportista'],'ruc',0);

            if($transportista == null){
                throw new ImportErrorException("El ruc del transportista ".$row['ruc_transportista']." es inválido en la fila ".$this->i);
            }

            $balanza = $this->getEntity($row['ruc_balanza'],'ruc',0);

            if($balanza == null){
                throw new ImportErrorException("El ruc de balanza ".$row['ruc_balanza']." es inválido en la fila ".$this->i);
            }

            Order::create([
                'ticket' => strtoupper($row['ticket']),
                'batch' => "O{$year}{$month}-{$correlative}",
                'client_id' => $cliente,
                'concentrate_id' => $concentrate->id,
                'wmt' => $row['tmh'],
                'origin' => $row['procedencia'],
                'carriage_company_id' => $transportista,
                'plate_number' => $row['numero_de_placa'],
                'transport_guide' => empty($row['guia_de_transporte']) ? '' : $row['guia_de_transporte'],
                'delivery_note' => empty($row['guia_de_remision']) ? '' : $row['guia_de_remision'],
                'weighing_scale_company_id' => $balanza,
                'settled' => false,
                'user_id' => Auth::user()->id,
            ]);
        }
    }

    public function getEntity($numero,$tipoDocumento,$address)
    {
        if(Entity::where('document_number',$numero)->exists()){
            $entity = Entity::where('document_number',$numero)->first();
        }else{
            $curl = curl_init();
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
                $entity = Entity::updateOrCreate(
                    [
                        'document_number' => $empresa->numeroDocumento,
                    ],
                    [
                        'name' => strtoupper($empresa->nombre),
                        'address' => strtoupper($address == 0 ? $empresa->direccion : $address),
                    ]
                );
            }else{
                $entity = null;
            }
        }
        if($entity != null){
            return $entity->id;
        }else{
            return null;
        }

    }

    public function onError(\Throwable $e)
    {
        // Se llama si ocurre un error en cualquier fila durante la importación
        // Puedes realizar acciones adicionales o registrar el error si es necesario
        DB::rollBack();
    }

    public function onFailure(\Throwable $e)
    {
        // Se llama si ocurre un error grave durante la importación antes de que se procese cualquier fila
        // Puedes realizar acciones adicionales o registrar el error si es necesario
        DB::rollBack();
    }

    public function getHasError()
    {
        return $this->hasError;
    }

    public function getErrorMessage()
    {
        return $this->errorMessage;
    }

    private function validateData($rowData)
    {
        // Realiza las validaciones necesarias en los datos importados
        // Retorna true si los datos cumplen con la regla, de lo contrario retorna false
    }

    public function checkDocumentNumber($numero)
    {
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

    public function getConcentrate($concentrate,$chemical_symbol){
        $concentrate = Concentrate::updateOrCreate(['concentrate' => $concentrate],['chemical_symbol'=>$chemical_symbol]);
        return $concentrate->id;
    }
}
