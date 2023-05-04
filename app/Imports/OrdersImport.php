<?php

namespace App\Imports;

use App\Models\AllowedAmount;
use App\Models\Concentrate;
use App\Models\Deduction;
use App\Models\DeductionTotal;
use App\Models\Entity;
use App\Models\InternationalPayment;
use App\Models\Law;
use App\Models\Order;
use App\Models\PayableTotal;
use App\Models\Penalty;
use App\Models\PenaltyTotal;
use App\Models\PercentagePayable;
use App\Models\Protection;
use App\Models\Refinement;
use App\Models\Requirement;
use App\Models\Settlement;
use App\Models\SettlementTotal;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\OnEachRow;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Row;

class OrdersImport implements OnEachRow,WithHeadingRow
{
    public function onRow(Row $row)
    {
        $tipoDocumento = $this->checkDocumentNumber($row['ruc_cliente']);
        if($row['ticket'] != "" && $row['ticket'] != null && $tipoDocumento != "" && Order::where('batch',$row['lote_orden'])->doesntExist()) {

            $order = Order::create([
                'ticket' => strtoupper($row['ticket']),
                'batch' => $row['lote_orden'],
                'client_id' => $this->getEntity($row['ruc_cliente'],$tipoDocumento,$row['direccion']),
                'concentrate_id' => $this->getConcentrate($row['concentrado'],$row['simbolo']),
                'wmt' => $row['tmh'],
                'origin' => $row['procedencia'],
                'carriage_company_id' => $this->getEntity($row['ruc_transportista'],'ruc',0),
                'plate_number' => $row['numero_de_placa'],
                'transport_guide' => $row['guia_de_transporte'],
                'delivery_note' => $row['guia_de_remision'],
                'weighing_scale_company_id' => $this->getEntity($row['ruc_balanza'],'ruc',0),
                'settled' => true,
                'user_id' => Auth::user()->id,
            ]);

            DB::transaction(function() use($order,$row){
                $settlement = Settlement::create([
                    'order_id' => $order->id,
                    'batch' => $row['lote_liquidacion'],
                    'with_invoice' => true,
                    'user_id' => Auth::user()->id
                ]);
                $internationalPayment = new InternationalPayment();
                $percentagePayable = new PercentagePayable();
                $law = new Law();
                $protection = new Protection();
                $deduction = new Deduction();
                $refinement = new Refinement();
                $requirement = new Requirement();
                $penalty = new Penalty();
                $allowedAmount = new AllowedAmount();
                $payableTotal = new PayableTotal();
                $deductionTotal = new DeductionTotal();
                $penaltyTotal = new PenaltyTotal();
                $settlementTotal = new SettlementTotal();

                $internationalPayment->settlement_id = $settlement->id;
                $internationalPayment->copper = $row['cobre_internacional'];
                $internationalPayment->silver = $row['plata_internacional'];
                $internationalPayment->gold = $row['oro_internacional'];
                $internationalPayment->save();

                $percentagePayable->settlement_id = $settlement->id;
                $percentagePayable->copper = $row['pagable_cobre'];
                $percentagePayable->silver = $row['pagable_plata'];
                $percentagePayable->gold = $row['pagable_oro'];
                $percentagePayable->save();

                $law->settlement_id = $settlement->id;
                $law->copper = $row['ley_cobre'];
                $law->humidity = $row['humedad'];
                $law->decrease = $row['merma'];
                $law->silver = $row['ley_plata'];
                $law->silver_factor = $row['factor_plata'];
                $law->gold = $row['ley_oro'];
                $law->gold_factor = $row['factor_oro'];
                $law->tms = $order->wmt*(100-$row['humedad'])/100;
                $law->tmns = $law->tms*(100-$row['merma'])/100;

                $protection->settlement_id = $settlement->id;
                $protection->copper = $row['proteccion_cobre'];
                $protection->silver = $row['proteccion_plata'];
                $protection->gold = $row['proteccion_oro'];
                $protection->save();

                $deduction->settlement_id = $settlement->id;
                $deduction->copper = $row['deduccion_cobre'];
                $deduction->silver = $row['deduccion_plata'];
                $deduction->gold = $row['deduccion_oro'];
                $deduction->save();

                $refinement->settlement_id = $settlement->id;
                $refinement->copper = $row['refinamiento_cobre'];
                $refinement->silver = $row['refinamiento_plata'];
                $refinement->gold = $row['refinamiento_oro'];
                $refinement->save();

                $requirement->settlement_id = $settlement->id;
                $requirement->maquila = $row['maquila'];
                $requirement->analysis = $row['analisis'];
                $requirement->stevedore = $row['estibadores'];
                $requirement->save();

                $penalty->settlement_id = $settlement->id;
                $penalty->arsenic = $row['penalidad_arsenico'];
                $penalty->antomony = $row['penalidad_antimonio'];
                $penalty->lead = $row['penalidad_plomo'];
                $penalty->zinc = $row['penalidad_zinc'];
                $penalty->bismuth = $row['penalidad_bismuto'];
                $penalty->mercury = $row['penalidad_mercurio'];
                $penalty->save();

                $allowedAmount->settlement_id = $settlement->id;
                $allowedAmount->arsenic = $row['maximo_arsenico'];
                $allowedAmount->antomony = $row['maximo_antimonio'];
                $allowedAmount->lead = $row['maximo_plomo'];
                $allowedAmount->zinc = $row['maximo_zinc'];
                $allowedAmount->bismuth = $row['maximo_bismuto'];
                $allowedAmount->mercury = $row['maximo_mercurio'];

                $payableTotal->settlement_id = $settlement->id;

                $payableTotalCopperPercent = ($row['ley_cobre']/100*$row['pagable_cobre']/100-$row['deduccion_cobre']/100);
                $payableTotal->unit_price_copper =floor((($row['cobre_internacional'] - $row['proteccion_cobre'])*2204.62)*1000)/1000;
                $payableTotal->total_price_copper =floor($payableTotal->unit_price_copper*$payableTotalCopperPercent*1000)/1000;

                $payableTotalSilverPercent = $row['ley_plata']*$row['factor_plata']*$row['pagable_plata']/100-$row['deduccion_plata'];
                $payableTotal->unit_price_silver =$row['plata_internacional'] - $row['proteccion_plata'];
                $payableTotal->total_price_silver =floor(($payableTotal->unit_price_silver*$payableTotalSilverPercent)*1000)/1000;

                $payableTotalGoldPercent = $row['ley_oro']*$row['factor_oro']*$row['pagable_oro']/100-$row['deduccion_oro'];
                $payableTotal->unit_price_gold =$row['oro_internacional'] - $row['proteccion_oro'];
                $payableTotal->total_price_gold =floor(($payableTotal->unit_price_gold*$payableTotalGoldPercent)*1000)/1000;

                $deductionTotal->settlement_id = $settlement->id;

                $deductionTotal->unit_price_copper = floor(2204.62*$row['refinamiento_cobre']*10000)/10000;
                $deductionTotal->total_price_copper = floor(($payableTotalCopperPercent*$deductionTotal->unit_price_copper)*1000)/1000;

                $deductionTotal->unit_price_silver = $row['refinamiento_plata'];
                $deductionTotal->total_price_silver = floor($payableTotalSilverPercent*$deductionTotal->unit_price_silver*1000)/1000;

                $deductionTotal->unit_price_gold = $row['refinamiento_oro'];
                $deductionTotal->total_price_gold = floor($payableTotalGoldPercent*$deductionTotal->unit_price_gold*1000)/1000;

                $deductionTotal->maquila = $row['maquila'];
                $deductionTotal->analysis = $row['analisis']/$law->tmns;
                $deductionTotal->stevedore = $row['estibadores']/$order->wmt;

                $penaltyTotal->settlement_id = $settlement->id;

                $penaltyTotal->leftover_arsenic = $row['penalidad_arsenico'] - $row['maximo_arsenico'] > 0 ? $row['penalidad_arsenico'] - $row['maximo_arsenico'] : 0;
                $penaltyTotal->leftover_antomony = $row['penalidad_antimonio'] - $row['maximo_antimonio'] > 0 ? $row['penalidad_antimonio'] - $row['maximo_antimonio'] : 0;
                $penaltyTotal->leftover_lead = $row['penalidad_plomo'] - $row['maximo_plomo'] > 0 ? $row['penalidad_plomo'] - $row['maximo_plomo'] : 0;
                $penaltyTotal->leftover_zinc = $row['penalidad_zinc'] - $row['maximo_zinc'] > 0 ? $row['penalidad_zinc'] - $row['maximo_zinc'] : 0;
                $penaltyTotal->leftover_bismuth = $row['penalidad_bismuto'] - $row['maximo_bismuto'] > 0 ? $row['penalidad_bismuto'] - $row['maximo_bismuto'] : 0;
                $penaltyTotal->leftover_mercury = $row['penalidad_mercurio'] - $row['maximo_mercurio'] > 0 ? $row['penalidad_mercurio'] - $row['maximo_mercurio'] : 0;

                $penaltyTotal->total_arsenic = $penaltyTotal->leftover_arsenic*100;
                $penaltyTotal->total_antomony = round($penaltyTotal->leftover_antomony*106.5,4,PHP_ROUND_HALF_DOWN);
                $penaltyTotal->total_lead = $penaltyTotal->leftover_lead*5;
                $penaltyTotal->total_zinc = $penaltyTotal->leftover_zinc*5;
                $penaltyTotal->total_bismuth = $penaltyTotal->leftover_bismuth*500;
                $penaltyTotal->total_mercury = $penaltyTotal->leftover_mercury/2;

                $settlementTotal->settlement_id = $settlement->id;

                $settlementTotal->payable_total = $payableTotal->total_price_copper+$payableTotal->total_price_silver+$payableTotal->total_price_gold;
                $settlementTotal->deduction_total = $deductionTotal->total_price_copper+$deductionTotal->total_price_silver+$deductionTotal->total_price_gold+$deductionTotal->maquila+$deductionTotal->analysis+$deductionTotal->stevedore;
                $settlementTotal->penalty_total = $penaltyTotal->total_arsenic+$penaltyTotal->total_antomony+$penaltyTotal->total_lead+$penaltyTotal->total_zinc+$penaltyTotal->total_bismuth+$penaltyTotal->total_mercury;
                $settlementTotal->unit_price = $settlementTotal->payable_total-$settlementTotal->deduction_total-$settlementTotal->penalty_total;
                $settlementTotal->batch_price = $settlementTotal->unit_price*$law->tmns;
                $settlementTotal->igv = $settlementTotal->batch_price*0.18;
                $settlementTotal->detraccion = ($settlementTotal->batch_price+$settlementTotal->igv)*0.1;
                $settlementTotal->total = $settlementTotal->batch_price+$settlementTotal->igv-$settlementTotal->detraccion;


                $penaltyTotal->save();

                $law->save();
                $payableTotal->save();
                $order->save();
                $allowedAmount->save();
                $deductionTotal->save();
                $settlementTotal->save();
            });
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
