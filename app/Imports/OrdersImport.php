<?php

namespace App\Imports;

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


    public function __construct()
    {
        // Obtener el número de lote más alto actual
        $latestBatch = DB::table('orders')->orderBy('batch', 'desc')->first();
        $this->latestBatchNumber = $latestBatch ? substr($latestBatch->batch, -4) : 0;
    }

    public function onRow(Row $row)
    {

        $tipoDocumento = $this->checkDocumentNumber($row['ruc_cliente']);
        if($row['ticket'] != "" && $row['ticket'] != null && $tipoDocumento != "") {

            $this->latestBatchNumber++;

            $concentrate = Concentrate::firstOrCreate([
                'concentrate' => $row['concentrado'],
                'chemical_symbol' => $row['simbolo']
            ]);

            $year = date('y');
            $month = date('m');
            $correlative = str_pad($this->latestBatchNumber, 4, '0', STR_PAD_LEFT);

            Order::create([
                'ticket' => strtoupper($row['ticket']),
                'batch' => "O{$year}{$month}-{$correlative}",
                'client_id' => $this->getEntity($row['ruc_cliente'],$tipoDocumento,empty($row['direccion']) ? '' : $row['direccion']),
                'concentrate_id' => $concentrate->id,
                'wmt' => $row['tmh'],
                'origin' => $row['procedencia'],
                'carriage_company_id' => $this->getEntity($row['ruc_transportista'],'ruc',0),
                'plate_number' => $row['numero_de_placa'],
                'transport_guide' => empty($row['guia_de_transporte']) ? '' : $row['guia_de_transporte'],
                'delivery_note' => empty($row['guia_de_remision']) ? '' : $row['guia_de_remision'],
                'weighing_scale_company_id' => $this->getEntity($row['ruc_balanza'],'ruc',0),
                'settled' => true,
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
            }
        }

        return $entity->id;
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
