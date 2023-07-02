<?php

namespace App\Http\Livewire\Order;

use App\Models\AllowedAmount;
use App\Models\Deduction;
use App\Models\DeductionTotal;
use App\Models\InternationalPayment;
use App\Models\Law;
use App\Models\Order;
use App\Models\PayableTotal;
use App\Models\Penalty;
use App\Models\PenaltyPrice;
use App\Models\PenaltyTotal;
use App\Models\PercentagePayable;
use App\Models\Protection;
use App\Models\Refinement;
use App\Models\Requirement;
use App\Models\Settlement;
use App\Models\SettlementTotal;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class SettleModal extends Component
{
    use LivewireAlert;

    public $open;
    public $open2;
    public $page;
    public $settlementId;
    public $orderId;
    public $date;
    public $batch;
    public $withInvoice;
    public $internationalCopper;
    public $internationalSilver;
    public $internationalGold;
    public $copperLaw;
    public $humidity;
    public $decrease;
    public $silverLaw;
    public $silverFactor;
    public $goldLaw;
    public $goldFactor;
    public $copperPayable;
    public $silverPayable;
    public $goldPayable;
    public $copperProtection;
    public $silverProtection;
    public $goldProtection;
    public $copperDeduction;
    public $silverDeduction;
    public $goldDeduction;
    public $copperRefinement;
    public $silverRefinement;
    public $goldRefinement;
    public $maquila;
    public $analysis;
    public $stevedore;
    public $arsenicPenalty;
    public $antomonyPenalty;
    public $leadPenalty;
    public $zincPenalty;
    public $bismuthPenalty;
    public $mercuryPenalty;
    public $arsenicPenaltyPrice;
    public $antomonyPenaltyPrice;
    public $leadPenaltyPrice;
    public $zincPenaltyPrice;
    public $bismuthPenaltyPrice;
    public $mercuryPenaltyPrice;
    public $arsenicMaximum;
    public $antomonyMaximum;
    public $leadMaximum;
    public $zincMaximum;
    public $bismuthMaximum;
    public $mercuryMaximum;

    public function mount(){
        $this->open = false;
        $this->open2 = false;
        $this->page = 1;
        $this->settlementId = 0;
        $this->orderId = 0;
        $this->date = Carbon::now()->toDateString();
        $this->batch = "";
        $this->withInvoice = false;
        $this->internationalCopper = "";
        $this->internationalSilver = "";
        $this->internationalGold = "";
        $this->copperLaw = "";
        $this->humidity = "";
        $this->decrease = "";
        $this->silverLaw = "";
        $this->silverFactor = 1;
        $this->goldLaw = "";
        $this->goldFactor = 1;
        $this->copperPayable = "";
        $this->silverPayable = "";
        $this->goldPayable = "";
        $this->copperProtection = "";
        $this->silverProtection = "";
        $this->goldProtection = "";
        $this->copperDeduction = "";
        $this->silverDeduction = "";
        $this->goldDeduction = "";
        $this->copperRefinement = "";
        $this->silverRefinement = "";
        $this->goldRefinement = "";
        $this->maquila = "";
        $this->analysis = "";
        $this->stevedore = "";
        $this->arsenicPenalty = "";
        $this->antomonyPenalty = "";
        $this->leadPenalty = "";
        $this->zincPenalty = "";
        $this->bismuthPenalty = "";
        $this->mercuryPenalty = "";
        $this->arsenicPenaltyPrice = "";
        $this->antomonyPenaltyPrice = "";
        $this->leadPenaltyPrice = "";
        $this->zincPenaltyPrice = "";
        $this->bismuthPenaltyPrice = "";
        $this->mercuryPenaltyPrice = "";
        $this->arsenicMaximum = "";
        $this->antomonyMaximum = "";
        $this->leadMaximum = "";
        $this->zincMaximum = "";
        $this->bismuthMaximum = "";
        $this->mercuryMaximum = "";
    }

    protected $listeners = ['abrirModal','settle'];

    public function abrirModal($settlementId,$orderId){
        if(Order::find($orderId)->settled && $settlementId == "0"){
            $this->alert('warning', '¡Orden ya liquidada!', [
                'position' => 'top-right',
                'timer' => 3500,
                'toast' => true,
                'text' => 'Vaya a liquidaciones para más detalles'
            ]);
        }else{
            $this->resetValidation();
            $this->resetExcept('open');
            $this->page = 1;
            $this->settlementId = $settlementId;
            $this->orderId = $orderId;
            $this->date = Carbon::now()->toDateString();
            $this->arsenicPenaltyPrice = 10;
            $this->antomonyPenaltyPrice = 10.65;
            $this->leadPenaltyPrice = 5;
            $this->zincPenaltyPrice = 5;
            $this->bismuthPenaltyPrice = 10;
            $this->mercuryPenaltyPrice = 10;
            if($settlementId > 0){
                $this->fillCamps($settlementId);
            }else{
                $client = Order::find($orderId)->client_id;
                $order = Order::where('client_id',$client)->where('settled',1)->orderBy('id','DESC')->first();
                if($order){
                    $settlement = Settlement::where('order_id',$order->id)->first();
                    $this->fillCamps($settlement->id);
                }else{
                    $this->fillCamps($settlementId);
                }
            }
            $this->open = true;
            $this->alert('success', '¡Datos Cargados!', [
                'position' => 'center',
                'timer' => 750,
                'toast' => false,
            ]);
        }
    }

    protected function rules(){
        return [
            'internationalCopper' => 'required|decimal:0,4',
            'internationalSilver' => 'required|decimal:0,4',
            'internationalGold' => 'required|decimal:0,4',
            'copperLaw' => 'required|decimal:0,4',
            'humidity' => 'required|decimal:0,4',
            'decrease' => 'required|decimal:0,4',
            'silverLaw' => 'required|decimal:0,4',
            'silverFactor' => 'required|decimal:0,4',
            'goldLaw' => 'required|decimal:0,4',
            'goldFactor' => 'required|decimal:0,4',
            'copperPayable' => 'required|decimal:0,4',
            'silverPayable' => 'required|decimal:0,4',
            'goldPayable' => 'required|decimal:0,4',
            'copperProtection' => 'required|decimal:0,4',
            'silverProtection' => 'required|decimal:0,4',
            'goldProtection' => 'required|decimal:0,4',
            'copperDeduction' => 'required|decimal:0,4',
            'silverDeduction' => 'required|decimal:0,4',
            'goldDeduction' => 'required|decimal:0,4',
            'copperRefinement' => 'required|decimal:0,4',
            'silverRefinement' => 'required|decimal:0,4',
            'goldRefinement' => 'required|decimal:0,4',
            'maquila' => 'required|decimal:0,4',
            'analysis' => 'required|decimal:0,4',
            'stevedore' => 'required|decimal:0,4',
            'arsenicPenalty' => 'required|decimal:0,4',
            'antomonyPenalty' => 'required|decimal:0,4',
            'leadPenalty' => 'required|decimal:0,4',
            'zincPenalty' => 'required|decimal:0,4',
            'bismuthPenalty' => 'required|decimal:0,4',
            'mercuryPenalty' => 'required|decimal:0,4',
            'arsenicMaximum' => 'required|decimal:0,4',
            'antomonyMaximum' => 'required|decimal:0,4',
            'leadMaximum' => 'required|decimal:0,4',
            'zincMaximum' => 'required|decimal:0,4',
            'bismuthMaximum' => 'required|decimal:0,4',
            'mercuryMaximum' => 'required|decimal:0,4',
        ];
    }

    public function messages(){
        return [
            'internationalCopper.required' => 'El campo es requerido',
            'internationalSilver.required' => 'El campo es requerido',
            'internationalGold.required' => 'El campo es requerido',
            'copperLaw.required' => 'El campo es requerido',
            'humidity.required' => 'El campo es requerido',
            'decrease.required' => 'El campo es requerido',
            'silverLaw.required' => 'El campo es requerido',
            'silverFactor.required' => 'El campo es requerido',
            'goldLaw.required' => 'El campo es requerido',
            'goldFactor.required' => 'El campo es requerido',
            'copperPayable.required' => 'El campo es requerido',
            'silverPayable.required' => 'El campo es requerido',
            'goldPayable.required' => 'El campo es requerido',
            'copperProtection.required' => 'El campo es requerido',
            'silverProtection.required' => 'El campo es requerido',
            'goldProtection.required' => 'El campo es requerido',
            'copperDeduction.required' => 'El campo es requerido',
            'silverDeduction.required' => 'El campo es requerido',
            'goldDeduction.required' => 'El campo es requerido',
            'copperRefinement.required' => 'El campo es requerido',
            'silverRefinement.required' => 'El campo es requerido',
            'goldRefinement.required' => 'El campo es requerido',
            'maquila.required' => 'El campo es requerido',
            'analysis.required' => 'El campo es requerido',
            'stevedore.required' => 'El campo es requerido',
            'arsenicPenalty.required' => 'El campo es requerido',
            'antomonyPenalty.required' => 'El campo es requerido',
            'leadPenalty.required' => 'El campo es requerido',
            'zincPenalty.required' => 'El campo es requerido',
            'bismuthPenalty.required' => 'El campo es requerido',
            'mercuryPenalty.required' => 'El campo es requerido',
            'arsenicMaximum.required' => 'El campo es requerido',
            'antomonyMaximum.required' => 'El campo es requerido',
            'leadMaximum.required' => 'El campo es requerido',
            'zincMaximum.required' => 'El campo es requerido',
            'bismuthMaximum.required' => 'El campo es requerido',
            'mercuryMaximum.required' => 'El campo es requerido',

            'internationalCopper.decimal' => '3 decimales como máximo',
            'internationalSilver.decimal' => '3 decimales como máximo',
            'internationalGold.decimal' => '3 decimales como máximo',
            'copperLaw.decimal' => '3 decimales como máximo',
            'humidity.decimal' => '3 decimales como máximo',
            'decrease.decimal' => '3 decimales como máximo',
            'silverLaw.decimal' => '3 decimales como máximo',
            'silverFactor.decimal' => '4 decimales como máximo',
            'goldLaw.decimal' => '3 decimales como máximo',
            'goldFactor.decimal' => '4 decimales como máximo',
            'copperPayable.decimal' => '3 decimales como máximo',
            'silverPayable.decimal' => '3 decimales como máximo',
            'goldPayable.decimal' => '3 decimales como máximo',
            'copperProtection.decimal' => '3 decimales como máximo',
            'silverProtection.decimal' => '3 decimales como máximo',
            'goldProtection.decimal' => '3 decimales como máximo',
            'copperDeduction.decimal' => '3 decimales como máximo',
            'silverDeduction.decimal' => '3 decimales como máximo',
            'goldDeduction.decimal' => '3 decimales como máximo',
            'copperRefinement.decimal' => '3 decimales como máximo',
            'silverRefinement.decimal' => '3 decimales como máximo',
            'goldRefinement.decimal' => '3 decimales como máximo',
            'maquila.decimal' => '3 decimales como máximo',
            'analysis.decimal' => '3 decimales como máximo',
            'stevedore.decimal' => '3 decimales como máximo',
            'arsenicPenalty.decimal' => '3 decimales como máximo',
            'antomonyPenalty.decimal' => '3 decimales como máximo',
            'leadPenalty.decimal' => '3 decimales como máximo',
            'zincPenalty.decimal' => '3 decimales como máximo',
            'bismuthPenalty.decimal' => '3 decimales como máximo',
            'mercuryPenalty.decimal' => '3 decimales como máximo',
            'arsenicMaximum.decimal' => '3 decimales como máximo',
            'antomonyMaximum.decimal' => '3 decimales como máximo',
            'leadMaximum.decimal' => '3 decimales como máximo',
            'zincMaximum.decimal' => '3 decimales como máximo',
            'bismuthMaximum.decimal' => '3 decimales como máximo',
            'mercuryMaximum.decimal' => '3 decimales como máximo',
        ];
    }

    private function fillCamps($settlementId){
        if($settlementId > 0){
            $settlement = Settlement::find($settlementId);
            $this->date = $this->date = Carbon::parse($settlement->date)->format('Y-m-d');
            $this->batch = $settlement->batch;
            $this->withInvoice = $settlement->with_invoice;
            $this->internationalCopper = floatval($settlement->InternationalPayment->copper);
            $this->internationalSilver = floatval($settlement->InternationalPayment->silver);
            $this->internationalGold = floatval($settlement->InternationalPayment->gold);
            $this->copperLaw = floatval($settlement->Law->copper);
            $this->humidity = floatval($settlement->Law->humidity);
            $this->decrease = floatval($settlement->Law->decrease);
            $this->silverLaw = floatval($settlement->Law->silver);
            $this->silverFactor = floatval($settlement->Law->silver_factor);
            $this->goldLaw = floatval($settlement->Law->gold);
            $this->goldFactor = floatval($settlement->Law->gold_factor);
            $this->copperPayable = floatval($settlement->PercentagePayable->copper);
            $this->silverPayable = floatval($settlement->PercentagePayable->silver);
            $this->goldPayable = floatval($settlement->PercentagePayable->gold);
            $this->copperProtection = floatval($settlement->Protection->copper);
            $this->silverProtection = floatval($settlement->Protection->silver);
            $this->goldProtection = floatval($settlement->Protection->gold);
            $this->copperDeduction = floatval($settlement->Deduction->copper);
            $this->silverDeduction = floatval($settlement->Deduction->silver);
            $this->goldDeduction = floatval($settlement->Deduction->gold);
            $this->copperRefinement = floatval($settlement->Refinement->copper);
            $this->silverRefinement = floatval($settlement->Refinement->silver);
            $this->goldRefinement = floatval($settlement->Refinement->gold);
            $this->maquila = floatval($settlement->Requirement->maquila);
            $this->analysis = floatval($settlement->Requirement->analysis);
            $this->stevedore = floatval($settlement->Requirement->stevedore);
            $this->arsenicPenalty = number_format($settlement->Penalty->arsenic,3);
            $this->antomonyPenalty = number_format($settlement->Penalty->antomony,3);
            $this->leadPenalty = number_format($settlement->Penalty->lead,3);
            $this->zincPenalty = number_format($settlement->Penalty->zinc,3);
            $this->bismuthPenalty = number_format($settlement->Penalty->bismuth,3);
            $this->mercuryPenalty = number_format($settlement->Penalty->mercury,3);
            $this->arsenicMaximum = number_format($settlement->AllowedAmount->arsenic,3);
            $this->antomonyMaximum = number_format($settlement->AllowedAmount->antomony,3);
            $this->leadMaximum = number_format($settlement->AllowedAmount->lead,3);
            $this->zincMaximum = number_format($settlement->AllowedAmount->zinc,3);
            $this->bismuthMaximum = number_format($settlement->AllowedAmount->bismuth,3);
            $this->mercuryMaximum = number_format($settlement->AllowedAmount->mercury,3);
            if(PenaltyPrice::where('settlement_id',$this->settlementId)->exists()){
                $this->arsenicPenaltyPrice = number_format($settlement->PenaltyPrice->arsenic,3);
                $this->antomonyPenaltyPrice = number_format($settlement->PenaltyPrice->antomony,3);
                $this->leadPenaltyPrice = number_format($settlement->PenaltyPrice->lead,3);
                $this->zincPenaltyPrice = number_format($settlement->PenaltyPrice->zinc,3);
                $this->bismuthPenaltyPrice = number_format($settlement->PenaltyPrice->bismuth,3);
                $this->mercuryPenaltyPrice = number_format($settlement->PenaltyPrice->mercury,3);
            }
        }else{
            $this->withInvoice = 0;
            $this->silverFactor = 1.1023;
            $this->goldFactor = 1.1023;
            $this->arsenicPenalty = 0;
            $this->antomonyPenalty = 0;
            $this->leadPenalty = 0;
            $this->zincPenalty = 0;
            $this->bismuthPenalty = 0;
            $this->mercuryPenalty = 0;
            $this->arsenicMaximum = 0;
            $this->antomonyMaximum = 0;
            $this->leadMaximum = 0;
            $this->zincMaximum = 0;
            $this->bismuthMaximum = 0;
            $this->mercuryMaximum = 0;
        }
    }

    public function confirmSettle(){
        $this->validate();
        if(Order::find($this->orderId)->settled && $this->settlementId == "0"){
            $this->alert('warning', '¡Orden ya liquidada!', [
                'position' => 'top-right',
                'timer' => 2000,
                'toast' => true,
            ]);
        }else{
            $this->open2 = true;
            $this->alert('info', '¡Verfirque los datos!', [
                'text' => 'Presione regresar si desea corregir',
                'position' => 'center',
                'timer' => 5000,
                'toast' => false,
                'showConfirmButton' => true,
                'confirmButtonText' => 'OK',
                'onConfirmed' => ''
            ]);
        }
    }

    public function settle(){
        try{
            DB::transaction(function(){
                    $order = Order::find($this->orderId);
                    $order->settled = true;

                    if($this->settlementId == 0){
                        $settlement = Settlement::create([
                            'order_id' => $this->orderId,
                            'batch' => $this->createBatch(),
                            'with_invoice' => $this->withInvoice,
                            'user_id' => Auth::user()->id,
                            'date' => $this->date
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
                        $penaltyPrice = new PenaltyPrice();
                        $payableTotal = new PayableTotal();
                        $deductionTotal = new DeductionTotal();
                        $penaltyTotal = new PenaltyTotal();
                        $settlementTotal = new SettlementTotal();
                    }else{
                        $settlement = Settlement::find($this->settlementId);
                        $settlement->with_invoice = $this->withInvoice;
                        $settlement->date = $this->date;
                        $settlement->user_id = Auth::user()->id;
                        $internationalPayment = InternationalPayment::where('settlement_id',$this->settlementId)->first();
                        $percentagePayable = PercentagePayable::where('settlement_id',$this->settlementId)->first();
                        $law = Law::where('settlement_id',$this->settlementId)->first();
                        $protection = Protection::where('settlement_id',$this->settlementId)->first();
                        $deduction = Deduction::where('settlement_id',$this->settlementId)->first();
                        $refinement = Refinement::where('settlement_id',$this->settlementId)->first();
                        $requirement = Requirement::where('settlement_id',$this->settlementId)->first();
                        $penalty = Penalty::where('settlement_id',$this->settlementId)->first();
                        $allowedAmount = AllowedAmount::where('settlement_id',$this->settlementId)->first();
                        if(PenaltyPrice::where('settlement_id',$this->settlementId)->exists()){
                            $penaltyPrice = PenaltyPrice::where('settlement_id',$this->settlementId)->first();
                        }else{
                            $penaltyPrice = new PenaltyPrice();
                        }
                        $payableTotal = PayableTotal::where('settlement_id',$this->settlementId)->first();
                        $deductionTotal = DeductionTotal::where('settlement_id',$this->settlementId)->first();
                        $penaltyTotal = PenaltyTotal::where('settlement_id',$this->settlementId)->first();
                        $settlementTotal = SettlementTotal::where('settlement_id',$this->settlementId)->first();
                    }

                    $internationalPayment->settlement_id = $settlement->id;
                    $internationalPayment->copper = $this->internationalCopper;
                    $internationalPayment->silver = $this->internationalSilver;
                    $internationalPayment->gold = $this->internationalGold;
                    $internationalPayment->save();

                    $percentagePayable->settlement_id = $settlement->id;
                    $percentagePayable->copper = $this->copperPayable;
                    $percentagePayable->silver = $this->silverPayable;
                    $percentagePayable->gold = $this->goldPayable;
                    $percentagePayable->save();

                    $law->settlement_id = $settlement->id;
                    $law->copper = $this->copperLaw;
                    $law->humidity = $this->humidity;
                    $law->decrease = $this->decrease;
                    $law->silver = $this->silverLaw;
                    $law->silver_factor = $this->silverFactor;
                    $law->gold = $this->goldLaw;
                    $law->gold_factor = $this->goldFactor;
                    $law->tms = $order->wmt*(100-$this->humidity)/100;
                    $law->tmns = $law->tms*(100-$law->decrease)/100;

                    $protection->settlement_id = $settlement->id;
                    $protection->copper = $this->copperProtection;
                    $protection->silver = $this->silverProtection;
                    $protection->gold = $this->goldProtection;
                    $protection->save();

                    $deduction->settlement_id = $settlement->id;
                    $deduction->copper = $this->copperDeduction;
                    $deduction->silver = $this->silverDeduction;
                    $deduction->gold = $this->goldDeduction;
                    $deduction->save();

                    $refinement->settlement_id = $settlement->id;
                    $refinement->copper = $this->copperRefinement;
                    $refinement->silver = $this->silverRefinement;
                    $refinement->gold = $this->goldRefinement;
                    $refinement->save();

                    $requirement->settlement_id = $settlement->id;
                    $requirement->maquila = $this->maquila;
                    $requirement->analysis = $this->analysis;
                    $requirement->stevedore = $this->stevedore;
                    $requirement->save();

                    $penalty->settlement_id = $settlement->id;
                    $penalty->arsenic = $this->arsenicPenalty;
                    $penalty->antomony = $this->antomonyPenalty;
                    $penalty->lead = $this->leadPenalty;
                    $penalty->zinc = $this->zincPenalty;
                    $penalty->bismuth = $this->bismuthPenalty;
                    $penalty->mercury = $this->mercuryPenalty;

                    $allowedAmount->settlement_id = $settlement->id;
                    $allowedAmount->arsenic = $this->arsenicMaximum;
                    $allowedAmount->antomony = $this->antomonyMaximum;
                    $allowedAmount->lead = $this->leadMaximum;
                    $allowedAmount->zinc = $this->zincMaximum;
                    $allowedAmount->bismuth = $this->bismuthMaximum;
                    $allowedAmount->mercury = $this->mercuryMaximum;

                    $penaltyPrice->settlement_id = $settlement->id;
                    $penaltyPrice->arsenic = $this->arsenicPenaltyPrice;
                    $penaltyPrice->antomony = $this->antomonyPenaltyPrice;
                    $penaltyPrice->lead = $this->leadPenaltyPrice;
                    $penaltyPrice->zinc = $this->zincPenaltyPrice;
                    $penaltyPrice->bismuth = $this->bismuthPenaltyPrice;
                    $penaltyPrice->mercury = $this->mercuryPenaltyPrice;

                    $payableTotal->settlement_id = $settlement->id;

                    $payableTotalCopperPercent = $this->copperLaw/100*$this->copperPayable/100-$this->copperDeduction/100;
                    $payableTotal->unit_price_copper =floor((($this->internationalCopper - $this->copperProtection)*2204.62)*1000)/1000;
                    $payableTotal->total_price_copper =floor($payableTotal->unit_price_copper*$payableTotalCopperPercent*1000)/1000;

                    $payableTotalSilverPercent = floor(((floor($this->silverLaw*$this->silverFactor*1000)/1000)*$this->silverPayable/100-$this->silverDeduction)*100)/100;
                    $payableTotal->unit_price_silver =$this->internationalSilver - $this->silverProtection;
                    $payableTotal->total_price_silver =floor(($payableTotal->unit_price_silver*$payableTotalSilverPercent)*1000)/1000;

                    $payableTotalGoldPercent =floor(((floor($this->goldLaw*$this->goldFactor*1000)/1000)*$this->goldPayable/100-$this->goldDeduction)*100)/100;
                    $payableTotal->unit_price_gold =$this->internationalGold - $this->goldProtection;
                    $payableTotal->total_price_gold =floor(($payableTotal->unit_price_gold*$payableTotalGoldPercent)*1000)/1000;

                    $deductionTotal->settlement_id = $settlement->id;

                    $deductionTotal->unit_price_copper = floor(2204.62*$this->copperRefinement*10000)/10000;
                    $deductionTotal->total_price_copper = floor(($payableTotalCopperPercent*$deductionTotal->unit_price_copper)*1000)/1000;

                    $deductionTotal->unit_price_silver = $this->silverRefinement;
                    $deductionTotal->total_price_silver = floor($payableTotalSilverPercent*$deductionTotal->unit_price_silver*1000)/1000;

                    $deductionTotal->unit_price_gold = $this->goldRefinement;
                    $deductionTotal->total_price_gold = floor($payableTotalGoldPercent*$deductionTotal->unit_price_gold*1000)/1000;

                    $deductionTotal->maquila = $this->maquila;
                    $deductionTotal->analysis = $this->analysis/$law->tmns;
                    $deductionTotal->stevedore = $this->stevedore/$order->wmt;

                    $penaltyTotal->settlement_id = $settlement->id;

                    $penaltyTotal->leftover_arsenic = $this->arsenicPenalty - $this->arsenicMaximum > 0 ? $this->arsenicPenalty - $this->arsenicMaximum : 0;
                    $penaltyTotal->leftover_antomony = $this->antomonyPenalty - $this->antomonyMaximum > 0 ? $this->antomonyPenalty - $this->antomonyMaximum : 0;
                    $penaltyTotal->leftover_lead = $this->leadPenalty - $this->leadMaximum > 0 ? $this->leadPenalty - $this->leadMaximum : 0;
                    $penaltyTotal->leftover_zinc = $this->zincPenalty - $this->zincMaximum > 0 ? $this->zincPenalty - $this->zincMaximum : 0;
                    $penaltyTotal->leftover_bismuth = $this->bismuthPenalty - $this->bismuthMaximum > 0 ? $this->bismuthPenalty - $this->bismuthMaximum : 0;
                    $penaltyTotal->leftover_mercury = $this->mercuryPenalty - $this->mercuryMaximum > 0 ? $this->mercuryPenalty - $this->mercuryMaximum : 0;

                    $penaltyTotal->total_arsenic = $penaltyTotal->leftover_arsenic*$penaltyPrice->arsenic*10;
                    $penaltyTotal->total_antomony = floor($penaltyTotal->leftover_antomony*$penaltyPrice->antomony*10000)/1000;
                    $penaltyTotal->total_lead = $penaltyTotal->leftover_lead*$penaltyPrice->lead;
                    $penaltyTotal->total_zinc = $penaltyTotal->leftover_zinc*$penaltyPrice->zinc;
                    $penaltyTotal->total_bismuth = $penaltyTotal->leftover_bismuth*$penaltyPrice->bismuth*100;
                    $penaltyTotal->total_mercury = $penaltyTotal->leftover_mercury*$penaltyPrice->mercury/20;

                    $settlementTotal->settlement_id = $settlement->id;

                    $settlementTotal->payable_total = $payableTotal->total_price_copper+$payableTotal->total_price_silver+$payableTotal->total_price_gold;
                    $settlementTotal->deduction_total = $deductionTotal->total_price_copper+$deductionTotal->total_price_silver+$deductionTotal->total_price_gold+$deductionTotal->maquila+$deductionTotal->analysis+$deductionTotal->stevedore;
                    $settlementTotal->penalty_total = $penaltyTotal->total_arsenic+$penaltyTotal->total_antomony+$penaltyTotal->total_lead+$penaltyTotal->total_zinc+$penaltyTotal->total_bismuth+$penaltyTotal->total_mercury;
                    $settlementTotal->unit_price = $settlementTotal->payable_total-$settlementTotal->deduction_total-$settlementTotal->penalty_total;
                    $settlementTotal->batch_price = $settlementTotal->unit_price*$law->tmns;
                    $settlementTotal->igv = $this->withInvoice == 1 ? $settlementTotal->batch_price*0.18 : 0;
                    $settlementTotal->detraccion = $this->withInvoice == 1 ? ($settlementTotal->batch_price+$settlementTotal->igv)*0.1 : 0;
                    $settlementTotal->total = $settlementTotal->batch_price+$settlementTotal->igv-$settlementTotal->detraccion;

                    $penalty->save();
                    $penaltyPrice->save();
                    $penaltyTotal->save();
                    $law->save();
                    $payableTotal->save();
                    $order->save();
                    $allowedAmount->save();
                    $deductionTotal->save();
                    $settlementTotal->save();
                    $settlement->save();
            });

            $this->alert('success', 'Orden Liquidada', [
                'position' => 'top-right',
                'timer' => 3500,
                'toast' => true,
               ]);
            $this->emit('render');
            $this->open = false;
            $this->open2 = false;
        }catch(\Exception $e){
            $this->alert('error', $e, [
                'position' => 'center',
                'timer' => 5000,
                'toast' => false,
               ]);
        }
    }

    public function createBatch(){
        $fecha = 'L'.Carbon::now()->isoFormat('YYMM');
        $correlativo = '0001';
        if(Settlement::limit(1)->exists()){
            $last_batch = explode("-",Settlement::orderBy('batch','desc')->first()->batch);
            if($fecha == $last_batch[0]){
                $correlativo = str_pad(strval(intval($last_batch[1])+1),4,0,STR_PAD_LEFT);
            }
        }

        return $fecha.'-'.$correlativo;
    }

    public function render()
    {
        return view('livewire.order.settle-modal');
    }
}
